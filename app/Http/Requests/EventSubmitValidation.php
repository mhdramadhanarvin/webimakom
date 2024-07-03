<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventSubmitValidation extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'phone_number' => ['required', 'phone:ID', 'min:10'],
            'gender' => ['required', 'in:male,female'],
            'institusion' => ['required', 'in:pancabudi,permikomnas,public'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Lengkap',
            'phone_number' => 'Nomor Whatsapp',
            'gender' => 'Jenis Kelamin',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => ':attribute tidak boleh kosong',
            'phone_number.phone' => 'Format :attribute harus sesuai',
            'phone_number.min' => 'Format :attribute harus sesuai',
        ];
    }
}
