<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
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
            'project_name' => 'required',
            'support_email' => 'email|required',
            'tawk_to' => 'nullable',
            'token_contract_address' => 'nullable',
            'presale_contract_address' => 'nullable',
            'token_decimals' => 'required',
            'token_symbol' => 'sometimes|nullable',
            'token_name' => 'sometimes|nullable',
            'token_image' => 'sometimes|image',
            'is_min_max_active' => 'boolean|required',
            'min_purchase_amount' => 'nullable',
            'max_purchase_amount' => 'nullable',
            'presale_start_date' => 'nullable',
            'presale_end_date' => 'nullable',
            'token_locking' => 'boolean|required',
            'sale_active' => 'boolean|required',
            'white_paper' => 'nullable|mimes:pdf|max:10000',
            'logo' => 'nullable|mimes:png,jpg,jpeg,svg|max:10000',
            'twitter' => 'nullable',
            'facebook' => 'nullable',
            'reddit' => 'nullable',
            'telegram_group' => 'nullable',
            'telegram_channel' => 'nullable',
            'medium' => 'nullable',
            'website' => 'nullable',
            'youtube' => 'nullable',
            'linkedin' => 'nullable',
            'instagram' => 'nullable',
            'slack' => 'nullable',
            'discord' => 'nullable',
            'github' => 'nullable',
            'notification_email' => 'email|required',
            'referral_prize' => 'sometimes|nullable',
            'referral_address' => 'sometimes|nullable',
            'soft_cap' => 'sometimes|nullable|numeric',
            'hard_cap' => 'sometimes|nullable|numeric',
            'total_tokens' => 'sometimes|nullable|numeric',
        ];
    }
}
