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
            // 'company_name' => 'required ',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'required',
            'img_path' => 'required'
            // required＝必須
            
        ];
    }
}
