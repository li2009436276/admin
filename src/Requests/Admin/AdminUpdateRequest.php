<?php


namespace Admin\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    public function authorize(){

        return true;
    }

    public function rules(){

        return [
            'id'            => 'required|integer|exists:admins',
            'pwd'           => 'required|min:5|max:32',
            'confirm_pwd'   => 'required|min:5|max:32|same:pwd',
            'account'       => [
                'required',
                'min:5',
                'max:20',
                Rule::unique('admins')->where(function ($query){
                    $query->where([['id','!=',$this->id]]);
                }),
            ],
            'nickname'      => 'required|max:30',
            'phone'         => [
                'required',
                'regex:/^1[3-9][0-9]{9}$/',
                Rule::unique('admins')->where(function ($query){
                    $query->where([['id','!=',$this->id]]);
                }),
            ],
            'email'         => [
                'required',
                'email',
                    Rule::unique('admins')->where(function ($query){
                        $query->where([['id','!=',$this->id]]);
                    }),
            ]
        ];
    }

    public function attributes()
    {
        return [
            'account'       => '账号',
            'pwd'           => '密码',
            'confirm_pwd'   => '确认密码',
            'nickname'      => '昵称',
            'phone'         => '手机号',
            'email'         => '邮箱'
        ];
    }
}