<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
	public function authorize(): bool
	{
		return $this->user()?->isAdmin() ?? false;
	}

	public function rules(): array
	{
		$userId = $this->route('user');

		return [
			'name'     => 'sometimes|required|string|max:255',
			'email'    => [
				'sometimes',
				'required',
				'email',
				'max:255',
				Rule::unique('users', 'email')->ignore($userId),
			],
			'role'     => ['sometimes', 'required', Rule::in(['admin', 'leader', 'support', 'viewer'])],
			'password' => 'nullable|string|min:6',
			'phone'    => 'nullable|string|max:20',
			'is_active' => 'nullable|boolean',
		];
	}

	public function messages(): array
	{
		return [
			'name.required'      => 'Nama user harus diisi.',
			'email.required'     => 'Email harus diisi.',
			'email.email'        => 'Format email tidak valid.',
			'email.unique'       => 'Email sudah digunakan oleh user lain.',
			'role.required'      => 'Role harus dipilih.',
			'role.in'            => 'Role yang dipilih tidak valid.',
			'password.min'       => 'Password minimal 6 karakter.',
		];
	}
}
