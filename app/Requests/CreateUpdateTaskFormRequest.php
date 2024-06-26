<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateTaskFormRequest extends FormRequest
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
        return [
            'name' => "required|min:3",
            'description' => "string|nullable",
            'completed' => "boolean|nullable"
        ];
    }
}
