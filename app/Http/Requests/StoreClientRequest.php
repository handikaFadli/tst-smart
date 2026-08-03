<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'client_type_id' => 'required|exists:client_types,id',
            'product_id' => 'required|exists:products,id',
            'pic_tim_id' => 'required|exists:users,id',
            'jumsis' => 'required|integer|min:0',
            'fitur_ids' => 'nullable|array',
            'fitur_ids.*' => 'exists:features,id',
            'server_id' => 'required|exists:servers,id',
            'kode_examol' => 'nullable|string|max:50',
            'url_aplikasi' => 'nullable|url|max:255',
            'link_presensi' => 'nullable|url|max:255',
            'aktivasi_aplikasi' => 'nullable|date',
            'expired_aplikasi' => 'nullable|date|after_or_equal:aktivasi_aplikasi',
            'expired_domain' => 'nullable|date',
            'status' => 'required|in:active,expired,trial,inactive',
            'catatan' => 'nullable|string|max:1000',

            // ─── Client Contract ───
            'nomor_kontrak' => 'nullable|string|max:100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'jumsis.min' => 'Jumlah siswa tidak boleh kurang dari 0.',
            'expired_aplikasi.after_or_equal' => 'Tanggal expired aplikasi harus setelah atau sama dengan aktivasi.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir kontrak harus setelah atau sama dengan tanggal mulai.',
            'file.mimes' => 'File kontrak harus berupa PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file kontrak maksimal 5 MB.',
        ];
    }
}
