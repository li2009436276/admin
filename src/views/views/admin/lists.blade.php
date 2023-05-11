@push('title')
    <title>管理员列表</title>
@endpush
@extends('layout.layer')
@section('content')
    <table id="test2" lay-filter="test2"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
@endsection
@push('script')
    <script>

        layui.use('table', function() {
            var $ = layui.$
                ,table = layui.table;

            table.render({
                elem: '#test2'
                ,url: '/admin/ajaxLists'
                ,page: { //详细参数可参考 laypage 组件文档
                    curr: 1
                    ,groups: 1
                    ,first: false
                    ,last: false
                    ,layout: ['limit', 'prev', 'page', 'next', 'count'] //自定义分页布局
                }
                //,height: 300
                ,cellMinWidth: 80
                //,skin: 'line'
                ,toolbar: false
                ,parseData: function (res) { //将原始数据解析成 table 组件所规定的数据
                    return {
                        "code": res.errcode, //解析接口状态
                        "msg": res.errmsg, //解析提示文本
                        "count": res.meta.total, //解析数据长度
                        "data":res.data,
                    };
                }
                ,request: {
                    pageName: 'page' //页码的参数名称，默认：page
                    ,limitName: 'pageSize' //每页数据量的参数名，默认：limit
                }
                ,cols: [[
                    {field: 'id', hide: true}
                    ,{field:'avatar', title:'头像',templet:function(row){
                        var headImg = '/default/img/user.png';
                            if (row.avatar != '' && row.avatar != null )  headImg = row.avatar.url;
                            return '<img style="width: 20px;height: 20px;" src="'+headImg+'">';
                        }}
                    ,{field: 'account', title: '账号'}
                    ,{field: 'nickname', title: '昵称'}
                    ,{field:'phone', title:'手机号'}
                    ,{field:'email', title:'邮箱'}
                    ,{field:'role_name', title:'角色'}
                    ,{field:'status', title:'状态',templet:function(row){
                            if (row.status == 1) return '正常';
                            else return '禁用';
                        }}
                    ,{title:'操作', align:'center', toolbar: '#barDemo'}
                ]]

            });

            //监听工具条
            table.on('tool(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('真的删除行么', function(index){

                        //向服务端发送删除指令
                        $.ajax({
                            url: '/admin/ajaxDelete'
                            , method: 'post'
                            , data: {id:data.id,_token:'{{csrf_token()}}'}
                            , dataType: 'json'
                            , success: function (data) {

                                layer.msg(data.errmsg, {
                                    offset: '15px'
                                    ,icon: 1
                                    ,time: 500
                                }, function(){});

                                if (data.errcode == 0) {

                                    obj.del(); //删除对应行（tr）的DOM结构
                                    layer.close(index);
                                }
                            },
                        });

                    });
                } else if(layEvent === 'edit'){
                    window.location.href = '/admin/update?id='+data.id;
                }
            });


        });

    </script>

@endpush