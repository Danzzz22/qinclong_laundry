<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // izinkan hanya user yang sudah login (lebih "lint-friendly" dari auth()->check())
        return Auth::check(); // atau: return $this->user() !== null;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'name'  => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                // unique di tabel users tapi abaikan email milik user yang sedang login
                Rule::unique('users', 'email')->ignore($userId),
            ],

            // usia opsional; jika diisi harus 1..120
            'age'   => ['nullable', 'integer', 'min:1', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.email'   => 'Format email tidak valid.',
            'email.unique'  => 'Email ini sudah digunakan pengguna lain.',
            'age.integer'   => 'Usia harus berupa angka.',
            'age.min'       => 'Usia minimal 1 tahun.',
            'age.max'       => 'Usia maksimal 120 tahun.',
        ];
    }
}
