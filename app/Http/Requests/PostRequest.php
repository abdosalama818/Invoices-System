<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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

                    'section_name' => 'required|string|unique:sections',
                    'description' => 'required|string',
                ];
            } case 'PUT':
             case 'PATCH': {
                return [
                    'section_name' => 'required|string',
                    'description' => 'required|string',
                ];
             }
             default:break;

            }
    }



/*     case 'PUT':
        case 'PATCH': */

    public function messages()
    {
        return [
            "section_name.required"=>"لايجب ترك الاسم فارغ",
            "description.required"=>"لا لايجب ترك الملاحظات فارغه ",
            "section_name.unique"=>"   هذا القسمم وجود فعليا",
        ];
    }
}
