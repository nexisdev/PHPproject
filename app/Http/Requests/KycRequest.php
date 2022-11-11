<?php

namespace App\Http\Requests;

use App\Enums\DocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class KycRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'sometimes',
            'address_line_1' => 'required',
            'address_line_2' => 'sometimes',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'document_type' => ['required', new EnumRule(DocumentType::class)],
            'document_front_side' => 'required|image',
            'document_back_side' => 'required_if:document_type,national_card',
            'wallet_address' => "required"
        ];
    }
}
