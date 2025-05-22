<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanMahasiswaRequest extends FormRequest
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
            'alamat_peneliti' => 'required|string',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'jurusan' => 'required|string|max:255',
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
            $mahasiswaId = $this->input('existing_id');
            
            // Untuk pengajuan ulang, tambahkan pengecualian pada aturan unique
            $rules['nim'] = 'required|string|max:20|regex:/^[0-9]+$/|unique:mahasiswa,nim,'.$mahasiswaId;
            $rules['email'] = 'required|email|max:255|unique:mahasiswa,email,'.$mahasiswaId;
            $rules['no_hp'] = 'required|string|max:15|regex:/^[0-9]+$/|unique:mahasiswa,no_hp,'.$mahasiswaId;
            
            // File tidak wajib jika ini pengajuan ulang (bisa gunakan file yang sudah ada)
            $rules['surat_pengantar_instansi'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['proposal_penelitian'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['ktp'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        } else {
            // Untuk pengajuan baru, tetap gunakan validasi unique tanpa pengecualian
            $rules['nim'] = 'required|string|max:20|regex:/^[0-9]+$/|unique:mahasiswa,nim';
            $rules['email'] = 'required|email|max:255|unique:mahasiswa,email';
            $rules['no_hp'] = 'required|string|max:15|regex:/^[0-9]+$/|unique:mahasiswa,no_hp';
            
            // File wajib untuk pengajuan baru
            $rules['surat_pengantar_instansi'] = 'required|file|mimes:pdf|max:2048';
            $rules['proposal_penelitian'] = 'required|file|mimes:pdf|max:2048';
            $rules['ktp'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
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
            'nim' => 'NIM',
            'email' => 'Email',
            'no_hp' => 'Nomor HP',
            'alamat_peneliti' => 'Alamat peneliti',
            'nama_instansi' => 'Nama instansi',
            'alamat_instansi' => 'Alamat instansi',
            'jurusan' => 'Jurusan/Fakultas',
            'judul_penelitian' => 'Judul penelitian',
            'lama_penelitian' => 'Lama penelitian',
            'tanggal_mulai' => 'Tanggal mulai',
            'tanggal_selesai' => 'Tanggal selesai',
            'lokasi_penelitian' => 'Lokasi penelitian',
            'tujuan_penelitian' => 'Tujuan penelitian',
            'anggota_peneliti' => 'Anggota peneliti',
            'surat_pengantar_instansi' => 'Surat pengantar instansi',
            'proposal_penelitian' => 'Proposal penelitian',
            'ktp' => 'KTP',
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
            'email' => ':attribute harus berupa alamat email yang valid.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'after_or_equal' => ':attribute harus setelah atau sama dengan tanggal mulai.',
            'unique' => ':attribute sudah terdaftar.',
            'file' => ':attribute harus berupa file.',
            'mimes' => ':attribute harus berupa file dengan tipe: :values.',
            'numeric' => ':attribute harus berupa angka.',
            'regex' => ':attribute hanya boleh berisi angka.',
            
            // Text field size limits
            'nim.max' => 'NIM tidak boleh lebih dari 20 angka.',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 15 angka.',
            'nama_lengkap.max' => 'Nama lengkap maksimal :max karakter.',
            'nama_instansi.max' => 'Nama instansi maksimal :max karakter.',
            'jurusan.max' => 'Jurusan/Fakultas maksimal :max karakter.',
            'lama_penelitian.max' => 'Lama penelitian maksimal :max karakter.',
            'email.max' => 'Email maksimal :max karakter.',
            
            // File size limits
            'surat_pengantar_instansi.max' => 'Surat pengantar instansi tidak boleh lebih dari 2 MB.',
            'proposal_penelitian.max' => 'Proposal penelitian tidak boleh lebih dari 2 MB.',
            'ktp.max' => 'KTP tidak boleh lebih dari 2 MB.',
        ];
    }
}