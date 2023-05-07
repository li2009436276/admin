<?php


namespace Admin\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class AdminAddRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            'account'       => 'required|unique:admins|min:5|max:20',
            'pwd'           => 'required|min:5|max:32',
            'confirm_pwd'   => 'required|min:5|max:32,same:pwd',
            'nickname'      => 'required|max:30',
            'phone'         => 'required|regex:/^1[3-9][0-9]{9}$/|unique:admins',
            'email'         => 'required|email|unique:admins'
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