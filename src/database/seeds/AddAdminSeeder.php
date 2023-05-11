<?php

use Illuminate\Database\Seeder;

class AddAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //时间，用于批量插入
        $time = date('Y-m-d H:i:s');

        //添加管理员
        $count = \Admin\Models\Admin::count();
        if ($count == 0) {

            $admin['role_id'] = 1;
            $admin['account'] = 'admin';
            $admin['salt'] = 'zsedc';
            $admin['pwd'] = md5($admin['salt'] . 'e10adc3949ba59abbe56e057f20f883e');
            $admin['nickname'] = 'admin';
            $admin['phone'] = '13373944332';
            $admin['email'] = '2066617574@qq.com';
            \Admin\Models\Admin::create($admin);
        }

        //添加角色
        $count = \Admin\Models\Role::count();
        if ($count == 0) {

            $roles['name'] = '超级管理员';
            \Admin\Models\Role::create($roles);
        }

        //添加路由
        $count = \Admin\Models\Route::count();
        if ($count == 0) {

            $routes = [

                //控制台
                [
                    'id' => 1,
                    'pid' => 0,
                    'path' => '/',
                    'name' => '控制台',
                    'icon' => 'layui-icon-user',
                    'status' => 2,
                    'created_at' => $time,
                    'updated_at' => $time
                ],

                //管理员管理
                [
                    'id' => 2,
                    'pid' => 0,
                    'path' => null,
                    'name' => '管理员管理',
                    'icon' => 'layui-icon-user',
                    'status' => 1,
                    'created_at' => $time,
                    'updated_at' => $time
                ],
                [
                    'id' => 3,
                    'pid' => 2,
                    'path' => '/admin/lists',
                    'name' => '管理员列表',
                    'icon' => null,
                    'status' => 1,
                    'created_at' => $time,
                    'updated_at' => $time
                ],
                [
                    'id' => 4,
                    'pid' => 2,
                    'path' => '/admin/add',
                    'name' => '添加管理员',
                    'icon' => null,
                    'status' => 1,
                    'created_at' => $time,
                    'updated_at' => $time
                ],
                [
                    'id' => 5,
                    'pid' => 2,
                    'path' => '/admin/update',
                    'name' => '管理员修改',
                    'icon' => null,
                    'status' => 2,//该路由不显示
                    'created_at' => $time,
                    'updated_at' => $time,
                ],
                [
                    'id' => 6,
                    'pid' => 2,
                    'path' => '/admin/ajaxDelete',
                    'name' => '管理员删除',
                    'icon' => null,
                    'status' => 2,//该路由不显示
                    'created_at' => $time,
                    'updated_at' => $time,
                ],

                //角色管理
                [
                    'id' => 7,
                    'pid' => 0,
                    'path' => null,
                    'name' => '角色管理',
                    'icon' => 'layui-icon-component',
                    'status' => 1,
                    'created_at' => $time,
                    'updated_at' => $time
                ],
                [
                    'id' => 8,
                    'pid' => 7,
                    'path' => '/role/lists',
                    'name' => '角色列表',
                    'icon' => null,
                    'status' => 1,
                    'created_at' => $time,
                    'updated_at' => $time
                ],
                [
                    'id' => 9,
                    'pid' => 7,
                    'path' => '/role/add',
                    'name' => '添加角色',
                    'icon' => null,
                    'status' => 1,
                    'created_at' => $time,
                    'updated_at' => $time
                ],
                [
                    'id' => 10,
                    'pid' => 7,
                    'path' => '/role/update',
                    'name' => '角色修改',
                    'icon' => null,
                    'status' => 2,//该路由不显示
                    'created_at' => $time,
                    'updated_at' => $time,
                ],
                [
                    'id' => 11,
                    'pid' => 7,
                    'path' => '/role/ajaxDelete',
                    'name' => '角色删除',
                    'icon' => null,
                    'status' => 2,//该路由不显示
                    'created_at' => $time,
                    'updated_at' => $time,
                ],
                [
                    'id' => 12,
                    'pid' => 7,
                    'path' => '/route/add',
                    'name' => '权限添加',
                    'icon' => null,
                    'status' => 2,//该路由不显示
                    'created_at' => $time,
                    'updated_at' => $time,
                ],
                [
                    'id' => 13,
                    'pid' => 7,
                    'path' => '/route/update',
                    'name' => '权限修改',
                    'icon' => null,
                    'status' => 2,//该路由不显示
                    'created_at' => $time,
                    'updated_at' => $time,
                ],
                [
                    'id' => 14,
                    'pid' => 7,
                    'path' => '/route/ajaxDelete',
                    'name' => '权限删除',
                    'icon' => null,
                    'status' => 2,//该路由不显示
                    'created_at' => $time,
                    'updated_at' => $time,
                ],
            ];

            \Admin\Models\Route::insert($routes);
        }

        //添加角色权限
        $count = \Admin\Models\RoleRoute::count();
        if ($count == 0) {

            $roleRoutes = [];
            for ($i = 1; $i < 15; $i++) {

                $roleRoutes[] = [

                    'role_id' => 1,
                    'route_id' => $i,
                    'created_at' => $time,
                    'updated_at' => $time,
                ];
            }

            \Admin\Models\RoleRoute::insert($roleRoutes);
        }
    }
}
