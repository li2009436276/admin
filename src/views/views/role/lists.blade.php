@push('title')
    <title>角色列表</title>
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

        layui.use(['table','form'], function() {
            var $ = layui.$
                ,table = layui.table
                ,form = layui.form;

            table.render({
                id: 'alert-lists'
                ,elem: '#test2'
                ,url: '/npc/role/ajaxLists'
                //,height: 300
                ,cellMinWidth: 80
                //,skin: 'line'
                ,toolbar: false
                ,parseData: function (res) { //将原始数据解析成 table 组件所规定的数据
                    return {
                        "code": res.errcode, //解析接口状态
                        "msg": res.errmsg, //解析提示文本
                        "data":res.data,
                    };
                }
                ,cols: [[
                    {field: 'id', hide: true}
                    ,{field: 'name', title: '名称'}
                    ,{title:'操作', align:'center', toolbar: '#barDemo'}
                ]]

            });

            //监听提交
            form.on('submit(*)', function(data){
                table.reload('alert-lists',{
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where:data.field
                });

                return false;
            });

            //监听工具条
            table.on('tool(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('真的删除行么', function(index){

                        //向服务端发送删除指令
                        $.ajax({
                            url: '/npc/role/ajaxDelete'
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
                    window.location.href = '/npc/role/update?id='+data.id;
                }
            });

        });

    </script>

@endpush

