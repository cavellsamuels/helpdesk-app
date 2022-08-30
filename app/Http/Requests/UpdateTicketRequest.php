<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
            'title' => 'max:255|regex:/^[a-zA-Z]+$/u',
            'details' => 'max:255|regex:/^[a-zA-Z]+$/u',
            'file' => 'max:10000'
        ];
    }
}