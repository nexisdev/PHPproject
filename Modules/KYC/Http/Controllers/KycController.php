<?php

namespace Zilab\KYC\Http\Controllers;

use App\Http\Requests\KycRequest;
use App\Models\Kyc;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends \App\Http\Controllers\Controller
{
    public function index(Request $request): Factory|View|Application
    {
        $kycList = Kyc::query()
            ->search($request->get('search'))
            ->when($request->get('status'), fn ($query, $status) => $query->where('status', $status))
            ->paginate();

        return view('kyc::admin.kyc.index', compact('kycList'));
    }

    public function show(Kyc $kyc)
    {
        return view('kyc::admin.kyc.show', compact('kyc'));
    }

    public function create()
    {
        return view('kyc::kyc.create');
    }

    public function store(KycRequest $request)
    {
        $kycData = collect($request->validated())->except(['document_front_side', 'document_back_side']);

        if($request->hasFile('document_front_side')) {
            $kycData['document_front_side'] = $request->document_front_side->store('public/images');
        }

        if($request->hasFile('document_back_side')) {
            $kycData['document_back_side'] = $request->document_back_side->store('public/images');
        }

        $kycData['user_id'] = Auth::id();

        kyc::create($kycData->toArray());

        return redirect()->route('kyc.thank-you');
    }

    public function destroy(Kyc $kyc)
    {
        $kyc->delete();

        return redirect()
            ->route('kyc.index')
            ->with(['success' => "You have deleted kyc for \"$kyc->first_name $kyc->last_name\" successfully!"]);
    }

    public function changeStatus(Kyc $kyc, Request $request)
    {
        $request->validate([
            'status' => 'in:approved,rejected'
        ]);

        $kyc->update(['status' => $request->status, 'checked_by' => Auth::user()->id, 'checked_at' => now()]);

        return redirect()
            ->route('kyc.index')
            ->with(['success' => "You have changed kyc status for \"$kyc->first_name $kyc->last_name\" to $request->status successfully!"]);
    }
}
