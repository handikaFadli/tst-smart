<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ClientPolicy handles authorization
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama' => 'sometimes|required|string|max:255',
            'client_type_id' => 'sometimes|required|exists:client_types,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'pic_tim_id' => 'sometimes|required|exists:users,id',
            'paket_fitur' => 'sometimes|nullable|array|max:10',
            'paket_fitur.*' => 'sometimes|string|max:50',
            'paket_id_card' => 'sometimes|nullable|string|max:100',
            'jumsis' => 'sometimes|required|integer|min:0',
            'fitur_ids' => 'sometimes|array',
            'fitur_ids.*' => 'exists:features,id',
            'server_id' => 'sometimes|required|exists:servers,id',
            'kode_examol' => 'sometimes|nullable|string|max:50',
            'url_aplikasi' => 'sometimes|nullable|url|max:255',
            'link_presensi' => 'sometimes|nullable|url|max:255',
            'aktivasi_aplikasi' => 'sometimes|nullable|date',
            'expired_aplikasi' => 'sometimes|nullable|date|after_or_equal:aktivasi_aplikasi',
            'expired_domain' => 'sometimes|nullable|date',
            'status' => 'sometimes|required|in:active,expired,trial,inactive',
            'catatan' => 'sometimes|nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'paket_fitur.array' => 'Paket fitur harus berupa pilihan ganda.',
            'paket_fitur.max' => 'Maksimal 10 paket fitur.',
            'jumsis.min' => 'Jumlah siswa tidak boleh kurang dari 0.',
            'expired_aplikasi.after_or_equal' => 'Tanggal expired aplikasi harus setelah atau sama dengan aktivasi.',
        ];
    }
}
