<?php

namespace App\Http\Controllers;

use App\Exceptions\TransactionCreateFailedException;
use App\Helpers\Cache;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Helpers\ContractHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Zilab\Referral\Entities\ReferralTransaction;

class TransactionV1Controller extends APIV1Controller
{
    public function index()
    {
        $transactions = Transaction::with('payableToken')->where('user_id', auth()->user()->id)->latest()->paginate();

        return view('transaction.index', compact('transactions'));
    }

    /**
     * @param TransactionRequest $request
     * @return JsonResponse
     */
    public function store(TransactionRequest $request): JsonResponse
    {
        try {
            $data = collect($request->validated());
            $data['user_id'] = auth()->user()->id;

            $transaction = Transaction::create($data->toArray());
            return response()->json(['message' => 'Transaction created successfully!', 'transaction_id' => $transaction->id]);
        } catch (TransactionCreateFailedException $exception) {
            Log::critical($exception->getMessage());
            return $this->jsonErrorResponse(
                'Could not store the transaction, please try again later!',
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function referralTransaction(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'wallet_address' => 'required',
        ]);

        $user = auth()->user();
        $user->load('referralBy');

        if(!$user->referralBy) return;
        if(ReferralTransaction::where('user_id', $user->id)->exists()) return;

        $abi = json_decode(file_get_contents(asset('contractsABI/referral.json')), true);
        $referralContractAddress = Cache::settings('referral_address');

        $referralUser = $user->referralBy;
        $referralUserAddress = $referralUser->wallet_address;
        $referredUserAddress = $request->wallet_address;
        $userReferralUrl = route('index', ['referral' => $user->referral_hash]);
        $prize = Cache::settings('referral_prize');

        try {
            $addReferralTransaction = ContractHelper::send(
                $referralContractAddress,
                $abi,
                'addReferralTransaction',
                $referralUserAddress,
                $referredUserAddress,
                $userReferralUrl,
                intval($prize * 10 ** 18),
            );

            Log::info('addReferralTransaction: ' . json_encode($addReferralTransaction) );

            $rewardReferralTransaction = ContractHelper::send(
                $referralContractAddress,
                $abi,
                'rewardReferral',
                $referralUserAddress,
                $referredUserAddress,
            );

            Log::info('rewardReferralTransaction: ' . json_encode($rewardReferralTransaction));

            ReferralTransaction::create([
                'user_id' => $user->id,
                'referral_id' => $referralUser->id,
                'prize' => $prize,
                'transaction_id' => $request->transaction_id,
                'blockchain_hash' => $rewardReferralTransaction->transactionHash,
                'status' => 'completed',
            ]);
        } catch(\Exception $e) {
            Log::critical($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Transaction completed successfully!']);
    }
}
