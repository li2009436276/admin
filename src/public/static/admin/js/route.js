var str = '<div id="route-layer" style="padding: 20px;">\n' +
    '        <form class="layui-form layui-form-pane1" id="route-form" action="#" lay-filter="first">\n' +
    '            <input type="hidden" name="_token" id="route-token">\n' +
    '            <input type="hidden" name="id" id="route-id">\n' +
    '            <input type="hidden" name="pid" id="route-pid">\n' +
    '            <div class="layui-form-item">\n' +
    '                <label class="layui-form-label layui-required">权限名称</label>\n' +
    '                <div class="layui-input-inline">\n' +
    '                    <input type="text" name="name" id="route-name" value="" lay-verify="required|title" maxlength="20" lay-reqText="权限名称" required placeholder="权限名称" autocomplete="off" class="layui-input" >\n' +
    '                </div>\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="layui-form-item">\n' +
    '                <label class="layui-form-label">权限路由</label>\n' +
    '                <div class="layui-input-inline">\n' +
    '                    <input type="text" name="path" id="route-path" value="" lay-verify="" maxlength="50" lay-reqText="权限路由" required placeholder="权限路由" autocomplete="off" class="layui-input" >\n' +
    '                </div>\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="layui-form-item">\n' +
    '                <label class="layui-form-label">图标</label>\n' +
    '                <div class="layui-input-inline">\n' +
    '                    <input type="text" name="icon" id="route-icon" value="" lay-verify="" maxlength="50" lay-reqText="图标" required placeholder="图标" autocomplete="off" class="layui-input" >\n' +
    '                </div>\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="layui-form-item">\n' +
    '                <label class="layui-form-label layui-required">排序</label>\n' +
    '                <div class="layui-input-inline">\n' +
    '                    <input type="text" name="sort" id="route-sort" value="1" lay-verify="required|integer" maxlength="20" lay-reqText="姓名" placeholder="姓名" autocomplete="off" class="layui-input">\n' +
    '                </div>\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="layui-form-item">\n' +
    '                <label class="layui-form-label">状态</label>\n' +
    '                <div class="layui-input-inline">\n' +
    '                    <select name="status" id="route-status" lay-filter="route-status">\n' +
    '                        <option value="1">显示</option>\n' +
    '                        <option value="2">隐藏</option>\n' +
    '                    </select>\n' +
    '                </div>\n' +
    '            </div>\n' +
    '\n' +
    '            <div class="layui-form-item">\n' +
    '                <div class="layui-input-block">\n' +
    '                    <button class="layui-btn" lay-submit lay-filter="route-form">立即提交</button>\n' +
    '                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>\n' +
    '                </div>\n' +
    '            </div>\n' +
    '        </form>\n' +
    '    </div>'

var routeLayer;

layui.use(['form', 'layer'], function() {
    var $ = layui.$
        , form = layui.form
        , layer = layui.layer;


    //权限弹框
    routeLayer = function (data,token,isUpdate) {

        //routeUrl
        var routeLayerUrl = '/route/ajaxAdd';

        var routeLayer = layer.open({
            title:'权限路由信息',
            type: 1,
            shade: false,//不需要遮罩层，设置模态与非模态的关键
            skin: 'layui-layer-rim',
            area: ['500px', '500px'],
            content: str
        });

        //判断data是否为空
        if (isUpdate) {

            routeLayerUrl = '/route/ajaxUpdate'
            $('#route-id').val(data.id);
            $('#route-name').val(data.name);
            $('#route-path').val(data.path);
            $('#route-icon').val(data.icon);
            $('#route-sort').val(data.sort);
            $('#route-status').val(data.status);
        }
        $('#route-token').val(token)
        $('#route-pid').val(data.pid);
        form.render('select');

        //监听提交
        form.on('submit(route-form)', function(data){

            $.ajax({
                url: routeLayerUrl
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

                        $('#alert-form')[0].reset();
                        location.reload();

                    }
                },
            });
            return false;
        });
    }
});