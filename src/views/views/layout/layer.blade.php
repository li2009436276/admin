@push('title')
    <title>后台管理</title>
@endpush
@push('style')
    <link rel="stylesheet" href="/static/admin/css/admin.css">
@endpush
@include('layout.header')
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    @if(!empty(session('admin')['head_img']))
                        <img src="{{session('admin')['head_img']['url']}}" class="layui-nav-img">
                    @else
                        <img src="/storage/app/public/img/user.png" class="layui-nav-img">
                    @endif
                    {{session('admin')['nickname']}}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="/admin/update?id={{session('admin')['id']}}">基本资料</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a id="logout" href="#">退出</a>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
            <div class="layui-logo" lay-href="">
                <span>后台管理</span>
            </div>
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                @if(!empty(\Illuminate\Support\Facades\Session::get('admin')['menus']))
                    @foreach(\Illuminate\Support\Facades\Session::get('admin')['menus'] as $value)
                        @if($value['pid'] == 0 && $value['status'] == 1)
                            <li class="layui-nav-item">
                                <a class="" href="javascript:;">
                                    <i class="layui-icon {{$value['icon']}}"></i>
                                    <cite>{{$value['name']}}</cite>
                                </a>
                                @if(count($value['children']))
                                    <dl class="layui-nav-child">
                                        @foreach($value['children'] as $k=>$v)
                                            @if($v['status'] == 1)
                                                <dd @if($v['path'] == '/'.request()->route()->uri())class="layui-this" @endif><a href="{{$v['path']}}">{{$v['name']}}</a></dd>
                                            @endif
                                        @endforeach
                                    </dl>
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div class="layui-work">
            @yield('content')
        </div>
    </div>
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © 客户管理系统 - 底部固定区域
    </div>
</div>
<script>

    layui.use(['element'], function(){
        var $ = layui.$
            ,element = layui.element;

        //控制菜单
        $('.layui-this').parent().parent().addClass('layui-nav-itemed');

        $('#logout').on('click',function (){
            $.ajax({
                url: '/login/ajaxLogout'
                , method: 'get'
                , success: function (data) {

                    if (data.errcode == 0) {

                        window.location.href = '/login/login'
                    }
                },
            });
        });
    });

</script>
@stack('script')
@include('layout.footer')
