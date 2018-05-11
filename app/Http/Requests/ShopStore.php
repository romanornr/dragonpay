<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopStore extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'website' => 'required|url|max:60',
            'expiration_time' => 'required|numeric|digits_between:2,4',
        ];
    }
}
