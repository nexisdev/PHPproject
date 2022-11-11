<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bought_amount' => 'required',
            'paid_amount' => 'required',
            'payable_token' => 'integer|required',
            'transaction_hash' => 'required',
            'wallet_address' => 'required'
        ];
    }
}
