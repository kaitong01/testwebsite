<?php

namespace App\Http\Requests;

use App\Models\TourSerie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Library\Fn;

class TourSerieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:175',
            'country_id' => 'required',

            'days' => 'required',
            'nights' => 'required',
            'price_at' => 'required',
            'description' => 'required',

            'permalink' => 'unique:tours_series,permalink',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'name.max' => 'ชื่อต้องไม่เกิน 175 ตัวอักษร',
            'name.min' => 'ชื่อต้องยาว 2 ตัวอักษรขึ้นไป',

            'description.required' => 'กรุณากรอกคำอธิบาย',

            'permalink.unique' => 'URL นี้ถูกใช้ไปแล้ว, กรุณากรอก URL ใหม่'

        ];
    }

    public function validator()
    {

        $rules = $this->rules();
        if($this->method()=='PUT'){
            $rules['permalink'] =  'unique:tours_series,permalink,'.$this->id;
        }

        $v = Validator::make($this->input(), $rules, $this->messages(), $this->attributes());


        $v->sometimes('permalink', 'unique:tours_series,permalink', function ($input) {

            $fn = new Fn;
            $permalink = $fn->q('text')->createPermalink($input->permalink);

            $where = [
                ['permalink', '=', $permalink],
                ['company_id', '=', Auth::user()->company->id],
            ];

            if( !empty($input->id) ){
                $where[] = ['id', '<>', $input->id];
            }

            $c = TourSerie::where($where)->count();

            return $c!=0;
        });


        return $v;
    }

    public function attributes()
    {
        return [
            'name' => 'ชื่อ',
        ];

    }

}
