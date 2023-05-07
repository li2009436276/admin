<?php


//登录
Route::get('/login/login','LoginController@login')->name('login');
Route::get('/login/captcha','LoginController@captcha');
Route::post('/login/ajaxLogin','LoginController@ajaxLogin');

//忘记密码
Route::get('/login/forget','LoginController@forget');
Route::post('/login/ajaxForget','LoginController@ajaxForget');

//需要验证用户登录
Route::group([
    'middleware' => 'admin.auth'
],function () {

    //操作台
    Route::get('/', 'IndexController@index');

    //管理员
    Route::get('/admin/add', 'AdminController@add');
    Route::post('/admin/ajaxAdd', 'AdminController@ajaxAdd');
    Route::get('/admin/lists', 'AdminController@lists');
    Route::get('/admin/ajaxLists', 'AdminController@ajaxLists');
    Route::get('/admin/update', 'AdminController@update');
    Route::post('/admin/ajaxUpdate', 'AdminController@ajaxUpdate');
    Route::post('/admin/ajaxDelete', 'AdminController@ajaxDelete');

    //角色
    Route::get('/role/add', 'RoleController@add');
    Route::post('/role/ajaxAdd', 'RoleController@ajaxAdd');
    Route::get('/role/lists', 'RoleController@lists');
    Route::get('/role/ajaxLists', 'RoleController@ajaxLists');
    Route::get('/role/update', 'RoleController@update');
    Route::post('/role/ajaxUpdate', 'RoleController@ajaxUpdate');
    Route::get('/route/add', 'RouteController@add');
    Route::post('/route/ajaxAdd', 'RouteController@ajaxAdd');
    Route::get('/route/update', 'RouteController@update');
    Route::post('/route/ajaxUpdate', 'RouteController@ajaxUpdate');
    Route::post('/route/ajaxDelete', 'RouteController@ajaxDelete');
});
