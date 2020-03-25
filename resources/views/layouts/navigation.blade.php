
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-icon-button">
        <a href="javascript:" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
    </li>
    <!-- END TOGGLE NAVIGATION -->
    <!-- POWER OFF -->
    <li class="xn-icon-button pull-right last">
       <a href="javascript:"><span class="glyphicon glyphicon-user"></span></a>
        <ul class="xn-drop-left animated zoomIn">
            <li><a href="{{ route('editUser') }}"><span class="glyphicon glyphicon-cog"></span> 修改个人资料</a></li>
            <li><a href="{{ url('logout') }}"><span class="fa fa-sign-out"></span> 退出</a></li>
        </ul>
    </li>
    <li class="xn-icon-button pull-right last">
        <h2 style="color: white;padding-top: 7px;margin-right: 20px;">{{$user->name}}</h2>
    </li>
    <!-- END POWER OFF -->
    <!-- 头像 -->
    {{--<li class="xn-icon-button pull-right">--}}
        {{--<a href="{{ route('profile') }}" class="avatar">--}}
            {{--<img src="{{ Auth::User()->info->avatar }}" onerror="this.src='/img/user_avatar.jpg'" alt="{{ Auth::User()->info->name }}">--}}
        {{--</a>--}}
    {{--</li>--}}
    <!-- END 头像 -->
</ul>

{{--@component('component.confirm')--}}
    {{--@slot('id', 'lock')--}}
    {{--@slot('title', '锁屏')--}}
    {{--@slot('goto', route('lock'))--}}
{{--确定进行锁屏操作吗?--}}
{{--@endcomponent--}}
