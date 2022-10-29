<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|unique:users',
            'email' => 'required|email',
            'phone' => 'required|regex:/[0-9\s]{13}/',
            'subject' => 'required|max:50',
            'message' => 'required|max:299'
        ];
    }
}
