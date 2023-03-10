<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'academic_degree' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'user_id'=>'required|exists:users,id'
        ];
    }
}
