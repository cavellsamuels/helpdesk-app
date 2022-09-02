<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            // 'title' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            // 'details' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'logged_by' => 'required',
            'urgency' => 'required',
            'category' => 'required',
            // 'open' => 'required',
            'file' => 'max:10000',
        ];
    }
}
