<?php


namespace Admin\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function authorize(){

        return true;
    }

    public function rules(){

        return [
            'name'      => 'required|max:20',
            'routes'    => 'required|array',
        ];
    }

    public function messages()
    {
        return [

            'name.required'     => '名称不能为空',
            'name.max'          => '名称最多20个字符',

            'routes.required'   => '权限不能为空',
            'routes.array'      => '权限为数组',
        ];
    }
}