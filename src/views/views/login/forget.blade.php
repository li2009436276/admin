
@push('title')
    <title>管理员登录</title>
@endpush

@push('style')
    <link rel="stylesheet" href="/static/admin/css/login/login.css">
@endpush

@include('layout.header')

<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h3>忘记密码</h3>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                <input type="text" name="account" id="LAY-user-login-username" maxlength="20" lay-verify="required" placeholder="账号" class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                <input type="password" name="pwd" id="LAY-user-login-password" maxlength="16" lay-verify="required" placeholder="密码" class="layui-input">
            </div>

            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                <input type="password" name="confirm_pwd" id="LAY-user-login-password" maxlength="16" lay-verify="required" placeholder="确认密码" class="layui-input">
            </div>

            <div class="layui-form-item" style="margin-bottom: 20px;">
                <a href="/login/login" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">去登录</a>
            </div>

            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="LAY-user-login-submit">提 交</button>
            </div>
        </div>
    </div>

</div>
<script src="/static/js/md5.js"></script>
<script>
    layui.use(['form','layer'], function(){
        var $ = layui.$
            ,form = layui.form
            ,layer=layui.layer;

        form.render();

        //提交
        form.on('submit(LAY-user-login-submit)', function(obj){
            obj.field.pwd = hex_md5(obj.field.pwd);
            obj.field.confirm_pwd = hex_md5(obj.field.confirm_pwd);
            //请求登入接口
            $.ajax({
                url: '/login/ajaxForget' //实际使用请改成服务端真实接口
                ,method: 'post'
                ,data: obj.field
                ,dataType: 'json'
                ,success: function(data){

                    //登入成功的提示与跳转
                    layer.msg(data.errmsg, {
                        offset: '15px'
                        ,icon: (data.errcode == 0 ? 1: 5)
                        ,time: 1000
                    }, function(){});

                    if (data.errcode == 0) {

                        location.href = '/admin/'; //后台主页
                    }
                }
            });
        });

    });
</script>

@include('layout.footer')