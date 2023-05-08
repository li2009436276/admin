<?php


namespace Admin\Requests\Login;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class LoginRequest extends FormRequest
{
    public function authorize(){

        return true;
    }

    public function rules(){

        return [
            'account'   => 'required|min:5|max:20',
            'pwd'       => 'required|size:32',
            'ver_code'  => 'required|size:5',
        ];
    }

    public function messages()
    {
        return [
            'account.required'   => '账号不能为空',
            'account.min'        => '账号最少5位',
            'account.max'        => '账号最多20位',

            'pwd.required'       => '密码不能为空',
            'pwd.size'           => '密码为32位',

            'ver_code.required'  => '验证码不能为空',
            'ver_code.size'      => '验证码为5位',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $verCode = Session::get('verCode');
            if (empty($verCode)) {
                $validator->errors()->add('3001', '验证码失效');
            }

            if (strtoupper($verCode) != strtoupper($this->ver_code)) {

                $validator->errors()->add('3001', '验证码错误');
            }
        });
    }
}