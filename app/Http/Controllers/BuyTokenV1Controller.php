<?php

namespace App\Http\Controllers;

use App\Helpers\Cache;
use App\Models\PayableToken;
use App\Models\Transaction;
use App\Models\User;
use Zilab\Referral\Entities\ReferralTransaction;

class BuyTokenV1Controller extends Controller
{
    public function index()
    {
        $payableTokens = PayableToken::active()->get();

        $hasReferralTransaction = ReferralTransaction::where('user_id', 1)->first();
        $referrelUser = null;

        if(!$hasReferralTransaction) {
            $referredBy = auth()->user()->referred_by;
            $referrelUser = User::find($referredBy);
        }

        $raisedAmount = round(Transaction::sum('bought_amount') * Cache::settings('token_price'), 2);

        return view('buy-token.index', compact('payableTokens', 'referrelUser', 'raisedAmount'));
    }
}
