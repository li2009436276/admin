<?php

return [
    'SUCCESS'           => [0, '成功'],
    'FAIL'              => [4001, '失败'],
    'UPDATE_SUCCESS'    => [0, '更新成功'],
    'UPDATE_FAIL'       => [4002, '更新失败'],
    'NO_AUTH'           => [433, '无权访问'],
    'NO_DATA'           => [4003, '无数据'],

    //业务
    'ACCOUNT_NOT_EXIST'   => [5001, '账号不存在'],
    'PWD_ERROR'           => [5002, '密码错误'],
    'LOGIN_SUCCESS'       => [0, '登录成功'],

    //权限
    'ROUTE_ADD_ERROR'       => [5101, '权限路由添加失败'],
    'ROLE_ROUTE_ADD_ERROR'  => [5102, '角色权限添加失败'],
    'ROLE_ADD_ERROR'        => [5103, '角色添加失败'],
    'RATE_TIMES_ADD_ERROR'  => [5104, '销售率查询次数添加失败'],
    'RATE_ORDER_CREAT_ERROR'=> [5105, '销售率订单创建失败'],
    'ADMIN_ADD_ERROR'       => [5106, '管理员添加失败'],
    'ADMIN_ATTR_ADD_ERROR'  => [5107, '管理员属性添加失败'],

];
