<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'last_name' => 'sometimes|required|string|max:40',
            'name' => 'sometimes|required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'email' => 'sometimes|required|string|email|max:80|unique:users,email,' . $this->route('id'),
            'phone' => 'sometimes|required|string|max:20|unique:users,phone,' . $this->route('id'),
        ];
    }
}
