<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class CartSerieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:175',

            'days' => 'required',
            'nights' => 'required',
            'price_at' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'name.max' => 'ชื่อต้องไม่เกิน 175 ตัวอักษร',
            'name.min' => 'ชื่อต้องยาว 2 ตัวอักษรขึ้นไป',

            'description.required' => 'กรุณากรอกคำอธิบาย',
        ];
    }

    public function validator()
    {
        return Validator::make($this->input(), $this->rules(), $this->messages(), $this->attributes());


        // $v->sometimes('permalink', 'unique:tours_series,permalink', function ($input) {

        //     $fn = new Fn;
        //     $permalink = $fn->q('text')->createPermalink($input->permalink);

        //     $where = [
        //         ['permalink', '=', $permalink],
        //         ['company_id', '=', Auth::user()->company->id],
        //     ];

        //     if( !empty($input->id) ){
        //         $where[] = ['id', '<>', $input->id];
        //     }

        //     $c = TourSerie::where($where)->count();

        //     return $c!=0;
        // });

    }

    public function attributes()
    {
        return [
            'name' => 'ชื่อ',
        ];

    }
}
