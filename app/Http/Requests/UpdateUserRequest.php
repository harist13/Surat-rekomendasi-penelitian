<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Pastikan pengguna memiliki izin admin
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nip' => ['required', 'numeric', Rule::unique('user')->ignore($this->route('id'))],
            'username' => ['required', Rule::unique('user')->ignore($this->route('id'))],
            'password' => 'nullable|min:6',
            'no_telp' => ['required', 'numeric', Rule::unique('user')->ignore($this->route('id')), 'min:10'],
            'email' => ['required', 'email', Rule::unique('user')->ignore($this->route('id'))],
            'role' => 'required|exists:roles,name',
        ];
    }

    /**
     * Get custom validation messages in Indonesian.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nip.required' => 'NIP tidak boleh kosong.',
            'nip.unique' => 'NIP sudah digunakan oleh pengguna lain.',
            'nip.numeric' => 'NIP harus berupa angka.',
            
            'username.required' => 'Username tidak boleh kosong.',
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
            
            'password.min' => 'Password minimal 6 karakter.',
            
            'no_telp.required' => 'Nomor telepon tidak boleh kosong.',
            'no_telp.numeric' => 'Nomor telepon harus berupa angka.',
            'no_telp.unique' => 'Nomor telepon sudah digunakan oleh pengguna lain.',
            'no_telp.min' => 'Nomor telepon minimal 10 digit.',
            
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            
            'role.required' => 'Role tidak boleh kosong.',
            'role.exists' => 'Role yang dipilih tidak valid.',
        ];
    }
}