<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;


class ProductPutRequest extends FormRequest
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
            'name'          => 'required|unique:product,name,'.$this->product.',id,deleted_at,NULL|max:64',
            'description'   => 'max:255',
            'price'         => 'required|numeric|between:0.99,99999.99',
            'category_id'   => 'required|exists:category,id'
        ];
    }
}
