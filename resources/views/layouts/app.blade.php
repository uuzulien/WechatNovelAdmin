<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '微信开发') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/theme-default.css') }}">
    <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/bootstrap/bootstrap-datetimepicker.min.css') }}">
    <!-- START PLUGINS -->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.pjax.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('layer/layer.js') }}"></script>
    <!-- 富文本编辑器 -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script> -->
    <!-- END PLUGINS -->
    @yield('css')
</head>
<body>
<div class="page-container page-navigation-top-fixed hidden">

    @section('sidebar')
        @include('layouts.sidebar')
    @show


    <div class="page-content">
    @section('navigation')
        @include('layouts.navigation')
    @show

    <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            @section('breadcrumb')
                <li><a href="{{ route('home') }}">首页</a></li>
            @show

        </ul>
        <!-- END BREADCRUMB -->

        <!-- PAGE TITLE -->
    @yield('pageTitle')
    <!-- END PAGE TITLE -->

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap" id="pjax-container" >
            @if (isset($errors) && count($errors) > 0)
                <div class="top_nav">
                    <div class="nav_menu">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(Session::has('alert-message'))
                <div class="top_nav">
                    <div class="nav_menu">
                        <div class="alert {{ session('alert-class') }}">
                            <ul>
                                <li>{{ session('alert-message') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->




<!-- START SCRIPTS -->

<!-- START THIS PAGE PLUGINS-->
<script type="text/javascript" src="{{ asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('js/plugins/scrolltotop/scrolltopcontrol.js') }}"></script>--}}

<script type='text/javascript' src='{{ asset('js/plugins/bootstrap/bootstrap-datetimepicker.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('js/plugins/bootstrap/bootstrap-datepicker.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('js/plugins/bootstrap/bootstrap-datepicker.zh-CN.min.js') }}'></script>
<script type="text/javascript" src="{{ asset('js/plugins/owl/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-file-input.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/icheck/icheck.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/moment.min.js') }}"></script>
<!-- END THIS PAGE PLUGINS-->

<!-- START TEMPLATE -->
<script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/actions.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script> -->
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->

@yield('js')
<!--
<script type="text/javascript" src="{{ asset('ueadit/ueditor.config.js') }}"></script>
<script type="text/javascript" src="{{ asset('ueadit/ueditor.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('ueadit/ueditor.parse.js') }}"></script> -->

<script>
    $(document).ready(function(){
        setTimeout(function () {$(".info-prompt").hide();},6000);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    //每个页面公共的方法
    $('.nav-pills > li').click(function () {
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
    })

    $('a:not(.noLoad)').on('click', function (event) {
        var href = $(this).attr('href');
        if (href.length > 5 && href.substr(0, 5) != 'javas'
            && !window.event.metaKey
            && !window.event.ctrlKey
            && !window.event.altKey
            && !window.event.shiftKey
        ) {
            pageLoadingFrame('show', 'v1');
        }
    });
    $('form:not(.noLoad)').on('submit', function () {
        pageLoadingFrame('show', 'v1');
    });
    if (localStorage.getItem('navigation.minimized')) {
        $('.page-container').addClass('page-navigation-toggled');
        x_navigation_minimize("close");
    }

    $('.page-container').removeClass('hidden');
</script>

<script>
    $('#Menus a[href="@yield('activeUrl', request()->url())"]').parents('li').addClass('active');
</script>

</body>
</html>
