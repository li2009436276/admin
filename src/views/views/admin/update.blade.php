@push('title')
    <title>管理员编辑</title>
@endpush

@extends('layout.layer')
@section('content')
    <form class="layui-form layui-form-pane1" action="" lay-filter="first">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{$id}}" class="layui-input" >
        <div class="layui-form-item">
            <label class="layui-form-label layui-required">用户账号</label>
            <div class="layui-input-inline">
                <input type="text" name="account" value="{{$account}}" lay-verify="required|title" maxlength="20" lay-reqText="用户账号" required placeholder="用户账号" autocomplete="off" class="layui-input" >
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label layui-required">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="pwd" value="{{$pwd}}" lay-verify="required" maxlength="32" lay-reqText="密码" required placeholder="密码" autocomplete="off" class="layui-input" >
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label layui-required">确认密码</label>
            <div class="layui-input-inline">
                <input type="password" name="confirm_pwd" value="{{$pwd}}" lay-verify="required" maxlength="32" lay-reqText="确认密码" required placeholder="确认密码" autocomplete="off" class="layui-input" >
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label layui-required">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="nickname" value="{{$nickname}}" lay-verify="required" maxlength="20" lay-reqText="姓名" placeholder="姓名" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label layui-required">手机号</label>
            <div class="layui-input-inline">
                <input type="tel" name="phone" value="{{$phone}}" lay-verify="required|number" maxlength="11" lay-reqText="手机号" placeholder="手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label layui-required">邮箱</label>
            <div class="layui-input-inline">
                <input type="email" name="email" value="{{$email}}" lay-verify="required|email" maxlength="20" lay-reqText="邮箱" placeholder="邮箱" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-inline">
                <div class="layui-upload-drag" id="test9">
                    <i class="layui-icon" id="headimg">
                        @if($avatar) <img style="width: 100px;height: 100px;" src="{{$avatar['url']}}" /> @else &#xe67c; @endif
                    </i>
                    <p>点击上传头像</p>
                </div>

                <input type="hidden" name="head_img" value="{{$avatar['path']}}" placeholder="上传头像" autocomplete="off" class="layui-input">

            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label layui-required">角色</label>
            <div class="layui-input-inline">
                <select name="role_id" id="role_id"  lay-filter="role_id" lay-search="">
                    @foreach($roles as $value)
                        <option value="{{$value['id']}}" @if(\Illuminate\Support\Facades\Session::get('admin')['id'] == $id && \Illuminate\Support\Facades\Session::get('admin')['role_id'] == $value['id']) selected="selected" @elseif($value['id'] == $role_id) selected="selected" @endif>{{$value['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-inline">
                <select name="status" lay-filter="interest">
                    <option value="1" @if($status == 1) selected @endif>正常</option>
                    <option value="2" @if($status == 2) selected @endif>禁用</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="/static/js/md5.js"></script>
    <script>
        layui.use(['form','upload'], function(){
            var $ = layui.$
                ,form = layui.form
                ,upload = layui.upload;

            //监听提交
            form.on('submit(*)', function(data){
                $.ajax({
                    url: '/admin/ajaxUpdate'
                    , method: 'post'
                    , data: data.field
                    , dataType: 'json'
                    , success: function (data) {

                        layer.msg(data.errmsg, {
                            offset: '15px'
                            ,icon: (data.errcode == 0 ? 1: 5)
                            ,time: 500
                        }, function(){});

                        if (data.errcode == 0) {

                            window.location.href = '/admin/lists'
                        }
                    },
                });
                return false;
            });

            upload.render({
                elem: '#test9'
                ,url: '/api/file/upload'
                ,done: function(res){
                    if (res.errcode == 0) {

                        $('#headimg').html('<img style="width: 100px;height: 100px" src="'+res.data[0].url+'"/>');
                        $('input[name=head_img]').val(res.data[0].path);
                    }
                }
            });

        });

    </script>
@endpush

