<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanNonMahasiswaRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:100',
            'alamat_peneliti' => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'bidang' => 'required|string|max:100',
            'judul_penelitian' => 'required|string',
            'lama_penelitian' => 'required|string|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi_penelitian' => 'required|string',
            'tujuan_penelitian' => 'required|string',
            'anggota_peneliti' => 'required|string',
            'status' => 'required|string',
        ];
        
        // Cek apakah ada existing_id (pengajuan ulang)
        if ($this->filled('existing_id')) {
            $nonMahasiswaId = $this->input('existing_id');
            
            // Untuk pengajuan ulang, tambahkan pengecualian pada aturan unique
            $rules['email'] = 'required|email|max:255|unique:non_mahasiswa,email,'.$nonMahasiswaId;
            $rules['no_hp'] = 'required|string|max:15|unique:non_mahasiswa,no_hp,'.$nonMahasiswaId;
            
            // File tidak wajib jika ini pengajuan ulang (bisa gunakan file yang sudah ada)
            $rules['surat_pengantar_instansi'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['akta_notaris_lembaga'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['surat_terdaftar_kemenkumham'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['ktp'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['proposal_penelitian'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['surat_pernyataan'] = 'nullable|file|mimes:pdf|max:2048';
        } else {
            // Untuk pengajuan baru, tetap gunakan validasi unique tanpa pengecualian
            $rules['email'] = 'required|email|max:255|unique:non_mahasiswa,email';
            $rules['no_hp'] = 'required|string|max:15|unique:non_mahasiswa,no_hp';
            
            // File wajib untuk pengajuan baru
            $rules['surat_pengantar_instansi'] = 'required|file|mimes:pdf|max:2048';
            $rules['akta_notaris_lembaga'] = 'required|file|mimes:pdf|max:2048';
            $rules['surat_terdaftar_kemenkumham'] = 'required|file|mimes:pdf|max:2048';
            $rules['ktp'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['proposal_penelitian'] = 'required|file|mimes:pdf|max:2048';
            $rules['surat_pernyataan'] = 'required|file|mimes:pdf|max:2048';
        }
        
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'nama_lengkap' => 'Nama lengkap',
            'jabatan' => 'Jabatan',
            'email' => 'Email',
            'no_hp' => 'Nomor HP',
            'alamat_peneliti' => 'Alamat peneliti',
            'nama_instansi' => 'Nama instansi',
            'alamat_instansi' => 'Alamat instansi',
            'bidang' => 'Bidang',
            'judul_penelitian' => 'Judul penelitian',
            'lama_penelitian' => 'Lama penelitian',
            'tanggal_mulai' => 'Tanggal mulai',
            'tanggal_selesai' => 'Tanggal selesai',
            'lokasi_penelitian' => 'Lokasi penelitian',
            'tujuan_penelitian' => 'Tujuan penelitian',
            'anggota_peneliti' => 'Anggota peneliti',
            'surat_pengantar_instansi' => 'Surat pengantar instansi',
            'akta_notaris_lembaga' => 'Akta notaris lembaga',
            'surat_terdaftar_kemenkumham' => 'Surat terdaftar Kemenkumham',
            'ktp' => 'KTP',
            'proposal_penelitian' => 'Proposal penelitian',
            'surat_pernyataan' => 'Surat Pernyataan bersedia memberikan hasil survei',
            'status' => 'Status',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute maksimal :max karakter.',
            'email' => ':attribute harus berupa alamat email yang valid.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'after_or_equal' => ':attribute harus setelah atau sama dengan tanggal mulai.',
            'unique' => ':attribute sudah terdaftar.',
            'file' => ':attribute harus berupa file.',
            'mimes' => ':attribute harus berupa file dengan tipe: :values.',
            'max' => ':attribute tidak boleh lebih dari 2 MB.',
            'numeric' => ':attribute harus berupa angka.',
        ];
    }
}