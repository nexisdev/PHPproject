<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ModuleHelper;
use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\PayableToken;
use App\Models\Transaction;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewType;
use Zilab\Referral\Entities\ReferralTraffic;
use Zilab\Referral\Entities\ReferralTransaction;

class AdminV1Controller extends Controller
{
    public function index(): ViewType
    {
        $payableTokens = PayableToken::all();

        // total sold amount
        $totalSoldAmount = Transaction::sum('bought_amount');

        // sold amount by token
        $soldAmountByToken = Transaction::selectRaw('payable_token, sum(bought_amount) as total')
            ->groupBy('payable_token')
            ->get();

        // how many bought amount for each day in the last 90 days
        $tokenSalesStatistics = Transaction::query()
            ->selectRaw('sum(bought_amount) as bought_amount, DATE(created_at) as date')
            ->whereDate('created_at', '>=', now()->subDays(90))
            ->groupBy('date')
            ->get();

        $response = [
            'payableTokens' => $payableTokens,
            'totalSoldAmount' => $totalSoldAmount,
            'soldAmountByToken' => $soldAmountByToken,
            'tokenSalesStatistics' => $tokenSalesStatistics,
        ];

        if(ModuleHelper::isActive('kyc')) {
            // how many kyc applicatoins for each day in the last 90 days
            $kycApplicationsStatistics = kyc::query()
                ->selectRaw('count(*) as count, DATE(created_at) as date')
                ->whereDate('created_at', '>=', now()->subDays(90))
                ->groupBy('date')
                ->get();

            // how many kyc applicatoins per status even if it's 0
            $kycApplicationsPerStatus = kyc::query()
                ->selectRaw('count(*) as count, status')
                ->groupBy('status')
                ->get();

            $kycApplicationsPerStatus = [
                'pending' => $kycApplicationsPerStatus->where('status', 'pending')->first()->count ?? 0,
                'approved' => $kycApplicationsPerStatus->where('status', 'approved')->first()->count ?? 0,
                'rejected' => $kycApplicationsPerStatus->where('status', 'rejected')->first()->count ?? 0,
            ];

            $response = array_merge($response, [
                'kycApplicationsStatistics' => $kycApplicationsStatistics,
                'kycApplicationsPerStatus' => $kycApplicationsPerStatus,
            ]);
        }

        if(ModuleHelper::isActive('referral')) {
            $referralTransactionQuery = ReferralTransaction::query();
            $totalReferralPrizes = $referralTransactionQuery->sum('prize');
            $totalReferredUsers = $referralTransactionQuery->count();

            $totalReferralVisits = ReferralTraffic::query()->count();

            $referralVisits = ReferralTraffic::query()
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

        return View::make('admin.dashboard', $response);
    }
}
