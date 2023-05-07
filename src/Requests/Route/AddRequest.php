<?php


namespace App\Http\Requests\Route;


use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function authorize(){

        return true;
    }

    public function rules(){

        return [
            'pid'       => 'nullable|integer|min:0',
            'sort'      => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [

            'pid.integer'    => '父级ID必须是正整数',
            'pid.min'        => '父级ID最小为1',
            'pid.exists'     => '父级ID不存在',

            'sort.required'   => '排序值不能为空',
            'sort.integer'    => '排序值必须是正整数',
            'sort.min'        => '排序值最小为1',
        ];
    }
}