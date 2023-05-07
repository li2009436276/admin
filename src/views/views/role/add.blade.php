@push('title')
    <title>角色修改</title>
@endpush
@extends('layout.layer')
@section('content')
    <form class="layui-form layui-form-pane1" id="alert-form" action="" lay-filter="first">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label layui-required">名称</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="" lay-verify="required|title" maxlength="20" lay-reqText="名称" required placeholder="名称" autocomplete="off" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label layui-required">权限</label>
            <div class="layui-input-inline">
                <div id="test1"></div>
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
    <script src="/static/admin/js/route.js"></script>
    <script>
        layui.use(['form','tree', 'layer'], function(){
            var $ = layui.$
                ,form = layui.form
                ,tree = layui.tree
                ,layer = layui.layer;

            tree.render({
                elem: '#test1'
                ,data: {!! json_encode($routes) !!}
                ,id: 'demoId1'
                ,click: function(obj){
                    if (obj.data.id == 0) {

                        layer.msg('根节点不可修改');
                        return false;
                    }

                    routeLayer(obj.data,'{{csrf_token()}}',1);
                }
                ,oncheck: function(obj){

                }
                ,operate: function(obj){
                    var type = obj.type;
                    if(type == 'add'){

                        routeLayer({pid:obj.data.id},'{{csrf_token()}}',0);
                    }else if(type == 'del'){

                        $.ajax({
                            url: '/route/ajaxDelete'
                            , method: 'post'
                            , data: {id:obj.data.id,_token:'{!! csrf_token() !!}'}
                            , dataType: 'json'
                            , success: function (data) {

                                layer.msg(data.errmsg, {
                                    offset: '15px'
                                    ,icon: (data.errcode == 0 ? 1: 5)
                                    ,time: 500
                                }, function(){});

                                if (data.errcode != 0) {


                                }
                            },
                        });

                    };
                }
                ,showCheckbox: true  //是否显示复选框
                ,accordion: 0  //是否开启手风琴模式

                ,onlyIconControl: true //是否仅允许节点左侧图标控制展开收缩
                ,isJump: 0  //点击文案跳转地址
                ,edit:  ['add', 'del']  //操作节点图标
                ,text:'routes'
            });

            //监听提交
            form.on('submit(*)', function(data){

                $.ajax({
                    url: '/role/ajaxAdd'
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
                        }
                    },
                });
                return false;
            });

        });
    </script>
@endpush
