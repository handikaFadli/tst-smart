<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_app_id' => 'required|exists:client_apps,id',
            'accounts' => 'required|array|min:1',
            'accounts.*.client_account_id' => 'nullable|integer|exists:client_accounts,id',
            'accounts.*.username' => 'required|string|max:255',
            'accounts.*.password' => 'required|string|min:6',
            'accounts.*.tipe_akun' => 'required|in:sekolah,support',
        ];
    }
}
