<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $id = $this->segment(3);

        return [
            'name' => "required|min:3",
            'email' => "required|unique:users,email,{$id},id",
            'password' => "required"
        ];
    }
}
