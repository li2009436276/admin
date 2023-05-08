<?php


namespace Admin\Requests\Login;



use Illuminate\Foundation\Http\FormRequest;

class ForgetRequest extends FormRequest
{
    public function authorize(){

        return true;
    }

    public function rules(){

        return [
            'account'       => 'required|min:5|max:20|exists:admins',
            'pwd'           => 'required|size:32',
            'confirm_pwd'   => 'required|size:32,same:pwd',
        ];
    }

    public function messages()
    {
        return [
            'account.required'   => '账号不能为空',
            'account.min'        => '账号最少5位',
            'account.max'        => '账号最多20位',
            'account.exists'     => '账号不存在',

            'pwd.required'       => '密码不能为空',
            'pwd.size'           => '密码为32位',

            'confirm_pwd.required'       => '确认密码不能为空',
            'confirm_pwd.size'           => '确认密码为32位',
            'confirm_pwd.same'           => '确认密码与密码不一致',
        ];
    }
}