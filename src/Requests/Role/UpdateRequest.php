<?php


namespace Admin\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(){

        return true;
    }

    public function rules(){

        return [
            'id'        => 'required|integer|exists:roles',
            'name'      => 'required|max:20',
            'routes'    => 'required|array',
        ];
    }

    public function messages()
    {
        return [

            'id.required'   => '角色ID不能为空',
            'id.integer'    => '角色ID必须是整数',
            'id.exists'     => '角色不存在',

            'name.required'     => '名称不能为空',
            'name.max'          => '名称最多20个字符',

            'routes.required'   => '权限不能为空',
            'routes.array'      => '权限为数组',
        ];
    }
}