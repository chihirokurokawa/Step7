<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MgtRequest extends FormRequest
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
            'product_name' => 'required',
            'company_id' => 'required ',
            'price' => 'required',
            'stock' => 'required',

            // 'comment' => 'required',
            'img_path' => 'file', 'mimes:jpeg,jpg,png',
            'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            // required＝必須
            
        ];
    }
}
