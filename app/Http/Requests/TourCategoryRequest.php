<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class TourCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:175',
            // 'description' => 'required',

            'image' => 'mimes:jpeg,jpg,png|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'name.max' => 'ชื่อต้องไม่เกิน 175 ตัวอักษร',
            'name.min' => 'ชื่อต้องยาว 2 ตัวอักษรขึ้นไป',

            'description.required' => 'กรุณากรอกคำอธิบาย',

            'image.required' => 'กรุณาใส่รูปภาพ',
            'image.mimes' => 'ชนิดของไฟล์ต้องเป็น .jpeg, .jpg, .png เท่านั้น',
            'image.max' => 'รับขนาดไฟล์สูงสุดที่จะอัปโหลดคือ 2MB',
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
