<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SitePageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:175',
            'description' => 'required|min:3|max:320',
            'content' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'name.min' => 'ชื่อต้องยาว 2 ตัวอักษรขึ้นไป',
            'name.max' => 'ชื่อต้องไม่เกิน 175 ตัวอักษร',

            'description.required' => 'กรุณากรอกคำอธิบาย',
            'description.min' => 'ชื่อต้องยาว 3 ตัวอักษรขึ้นไป',
            'description.max' => 'ชื่อต้องไม่เกิน 320 ตัวอักษร',

            'content.required' => 'กรุณากรอกเนื้อหา',
            'content.min' => 'ชื่อต้องยาว 3 ตัวอักษรขึ้นไป',

        ];
    }

    public function validator()
    {
        return Validator::make($this->input(), $this->rules(), $this->messages(), $this->attributes());
    }

    public function attributes()
    {
        return [
            'name' => 'ชื่อ',
        ];

    }
}
