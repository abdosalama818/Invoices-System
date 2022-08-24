<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch($this->method()){
            case "POST":{
                return [
                    'Product_name' => 'required|string|unique:products',
                    'section_id' => 'required',
                    'description' => 'required|string',
                ];
            } case 'PUT':
            case 'PATCH': {
                return [
                    'Product_name' => 'required|string',
                    'section_id' => 'required',
                    'description' => 'required|string',
                ];
            }
            default:break;

        }
    }



    public function messages()
    {
        return [
            "section_id.required"=>"لايجب ترك القسم فارغ",
            "description.required"=>"لا لايجب ترك الملاحظات فارغه ",
            "Product_name.unique"=>"   هذا القسمم وجود فعليا",
            "Product_name.required"=>" لايجب ترك اسم المنتج فارغ ",
        ];
    }
}
