<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayableTokenRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => (bool) $this->status,
        ]);
    }

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
            'contract_address' => $this->method() === 'POST' ? 'required|string|max:255' : 'sometimes|nullable|string|max:255',
            'symbol' => 'required|string|max:5',
            'name' => 'required|string|max:255',
            'decimals' => $this->method() === 'POST' ? 'required|integer' : 'sometimes|nullable|integer',
            'image' => $this->method() === 'POST' ? 'required|image' : 'sometimes|image',
            'status' => 'required|boolean',
        ];
    }
}
