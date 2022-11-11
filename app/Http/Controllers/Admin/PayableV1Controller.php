<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayableTokenRequest;
use App\Models\PayableToken;
use Illuminate\Http\Request;

class PayableV1Controller extends Controller
{
    public function index()
    {
        $tokens = PayableToken::paginate();

        return view('admin.payable-tokens.index', compact('tokens'));
    }

    public function create()
    {
        return view('admin.payable-tokens.create');
    }

    public function store(PayableTokenRequest $request)
    {
        $data = collect($request->validated())->except('image');

        if($request->hasFile('image')) {
            $data['image'] = $request->image->store('public/images/tokens');
        }

        PayableToken::create($data->toArray());

        return redirect()
            ->route('payable-tokens.index')
            ->with(['success' => 'You have add new payable token successfully !']);
    }

    public function edit(PayableToken $payableToken)
    {
        return view('admin.payable-tokens.edit', compact('payableToken'));
    }

    public function update(PayableTokenRequest $request, PayableToken $payableToken)
    {
        $data = collect($request->validated())->except('image');

        if($request->hasFile('image')) {
            $data['image'] = $request->image->store('public/images/tokens');
        }

        $payableToken->update($data->toArray());

        return redirect()
            ->route('payable-tokens.index')
            ->with(['success' => "You have update payable token \" $payableToken->symbol \" successfully !"]);
    }

    public function destroy(PayableToken $payableToken)
    {
        $payableToken->delete();

        return redirect()
            ->route('payable-tokens.index')
            ->with(['success' => "You have delete payable token \" $payableToken->symbol \" successfully !"]);
    }
}
