@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>编辑资料</li>
@endsection
@section('css')
<style type="text/css">
    .panel-heading {
        height: 70px;
    }
    .panel-footer {
        height: 50px;
    }
</style>
@endsection
@section('pageTitle')
@endsection
@section('content')
    @if (isset($errors) && count($errors->all()) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (isset($result) && $result=='yes')
        <div class="alert alert-success">
            <ul>
                <li>保存成功</li>
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="post" action="{{route('saveUser')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                                个人资料
                        </h3>
                    </div>
                    <div class="panel-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">用户名</label>
                                <div class="col-md-6 col-xs-12">
                                    <input type="hidden" class="form-control" name="name" value="{{ $userInfo->name }}">
                                    <p class="form-control-static">{{ $userInfo->name }}</p>
                                </div>
                            </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">密码</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="password" class="form-control" name="password" autocomplete="new-password">
                                    留空代表不更改密码
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Email</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="text" class="form-control" name="email" value="{{ $userInfo->email ?? old('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
