<?php

namespace App\Http\Controllers;

use App\Helpers\ModuleHelper;
use App\Models\PayableToken;
use App\Models\Transaction;
use Zilab\Referral\Entities\ReferralTraffic;
use Zilab\Referral\Entities\ReferralTransaction;

class UserDashboardV1Controller extends Controller
{
    public function index()
    {

        $payableTokens = PayableToken::all();

        $transactionQuery = Transaction::query()
            ->where('user_id', auth()->user()->id);

        $totalBoughtAmount = $transactionQuery->sum('bought_amount');

        $boughtAmountByToken = $transactionQuery->selectRaw('payable_token, sum(bought_amount) as total')
            ->groupBy('payable_token')
            ->get();

        // how many bought amount for each day in the last 90 days
        $tokenSalesStatistics = $transactionQuery
            ->selectRaw('sum(bought_amount) as bought_amount, DATE(created_at) as date')
            ->whereDate('created_at', '>=', now()->subDays(90))
            ->groupBy('date')
            ->get();

            $response = [
                'payableTokens' => $payableTokens,
                'totalBoughtAmount' => $totalBoughtAmount,
                'boughtAmountByToken' => $boughtAmountByToken,
                'tokenSalesStatistics' => $tokenSalesStatistics,
            ];

        if(ModuleHelper::isActive('referral')) {
            $referralTransactionQuery = ReferralTransaction::query()
                ->where('referral_id', auth()->user()->id);

            $totalReferralPrizes = $referralTransactionQuery->sum('prize');
            $totalReferredUsers = $referralTransactionQuery->count();

            $totalReferralVisits = ReferralTraffic::query()
                ->where('referral_hash', auth()->user()->referral_hash)
                ->count();

            $referralVisits = ReferralTraffic::query()
                ->where('referral_hash', auth()->user()->referral_hash)
                ->selectRaw('count(id) as visits, DATE(created_at) as date')
                ->whereDate('created_at', '>=', now()->subDays(90))
                ->groupBy('date')
                ->get();

            $response = array_merge($response, [
                'totalReferralPrizes' => $totalReferralPrizes,
                'totalReferredUsers' => $totalReferredUsers,
                'totalReferralVisits' => $totalReferralVisits,
                'referralVisits' => $referralVisits,
            ]);
        }

        return view('dashboard', $response);
    }
}
