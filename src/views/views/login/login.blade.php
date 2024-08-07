
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
            <h2>登录</h2>
            <p>客户管理系统</p>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form" lay-filter="first">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                <input type="text" name="account" id="LAY-user-login-username" lay-verify="required" maxlength="20" placeholder="账号" class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                <input type="password" name="pwd" id="LAY-user-login-password" lay-verify="required" maxlength="16" placeholder="密码" class="layui-input">
            </div>

            <div class="layui-form-item">
                <div class="layui-row">
                    <div class="layui-col-xs7">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
                        <input type="text" name="ver_code" id="LAY-user-login-vercode" maxlength="5" lay-verify="required" placeholder="图形验证码" class="layui-input">
                    </div>
                    <div class="layui-col-xs5">
                        <div style="margin-left: 10px;">
                            <img src="/npc/login/captcha" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-form-item" style="margin-bottom: 20px;">
                <input type="checkbox" name="remember" lay-skin="primary" title="记住密码"><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>记住密码</span><i class="layui-icon layui-icon-ok"></i></div>
                <a href="/npc/login/forget" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="LAY-user-login-submit">登 入</button>
            </div>
        </div>
    </div>

</div>
<script src="/static/js/md5.js"></script>
<script>

    layui.use(['form','layer'], function(){
        var $ = layui.$
            ,form = layui.form
            ,layer = layui.layer;


        //处理记住密码
        var oUser = $('input[name="account"]');
        var oPswd = $('input[name="pwd"]');
        var oRemember = $('input[name="remember"]');
        if (getCookie('account') && getCookie('pwd')) {
            oUser.val(getCookie('account')) ;
            oPswd.val(getCookie('pwd')) ;
            oRemember.attr('checked','checked');
            form.render("checkbox");
        }

        //图形验证码
        $('#LAY-user-get-vercode').on('click',function (){
            $(this).attr('src','/npc/login/captcha?v='+Math.random());
        });

        var loginFunction = function (obj) {

            obj.pwd = hex_md5(obj.pwd);
            //请求登入接口
            $.ajax({
                url: '/npc/login/ajaxLogin' //实际使用请改成服务端真实接口
                ,method: 'post'
                ,data: obj
                ,dataType: 'json'
                ,success: function(data){

                    //登入成功的提示与跳转
                    layer.msg(data.errmsg, {
                        offset: '15px'
                        ,icon: (data.errcode == 0 ? 1: 5)
                        ,time: 1000
                    }, function(){});

                    if (data.errcode == 0) {

                        if (oRemember.prop('checked')) {
                            setCookie('account', oUser.val(), 7); //保存帐号到cookie，有效期7天
                            setCookie('pwd', oPswd.val(), 7); //保存密码到cookie，有效期7天
                        } else {

                            delCookie('account');
                            delCookie('pwd');
                        }

                        location.href = '/npc'; //后台主页
                    }
                }
            });
        }

        //提交
        form.on('submit(LAY-user-login-submit)', function(obj){

            loginFunction(obj.field);
        });


        // 监听Enter键
        document.addEventListener('keydown', function(event){
            if(event.keyCode === 13){ // 检查按键是否是Enter
                // 触发Layui的form提交事件
                var formData = form.val('first');
                loginFunction(formData);
            }
        });


        //设置cookie
        function setCookie(name, value, day) {
            var date = new Date();
            date.setDate(date.getDate() + day);
            document.cookie = name + '=' + value + ';expires=' + date;
        };

        //获取cookie
        function getCookie(name) {
            var reg = RegExp(name + '=([^;]+)');
            var arr = document.cookie.match(reg);
            if (arr) {
                return arr[1];
            } else {
                return '';
            }
        };

        //删除cookie
        function delCookie(name) {
            setCookie(name, null, -1);
        }

    });
</script>

@include('layout.footer')