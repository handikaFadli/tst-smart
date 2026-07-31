<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClientAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_app_id' => 'required|exists:client_apps,id',
            'accounts' => 'required|array|min:1',
            'accounts.*.username' => 'required|string|max:255',
            'accounts.*.password' => 'required|string|min:6',
            'accounts.*.tipe_akun' => 'required|in:sekolah,support',
        ];
    }
}
