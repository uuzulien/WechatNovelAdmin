@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>用户管理</li>

    @if(isset($data->id))
        <li>更新用户</li>
    @else
        <li>新增用户</li>
    @endif
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
{{--    @if (count($errors) > 0)--}}
{{--        <div class="alert alert-danger">--}}
{{--            <ul>--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <li>{{ $error }}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    @endif--}}
    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" method="post" action="{{route('admin_user.save')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            @if(isset($data->id))
                                更新用户
                            @else
                                新增用户
                            @endif
                        </h3>
                    </div>
                    <div class="panel-body">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        @if(isset($data->id))
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">用户名</label>
                                <div class="col-md-6 col-xs-12">
                                    <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                                    <p class="form-control-static">{{ $data->name }}</p>
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">用户名</label>
                                <div class="col-md-6 col-xs-12">
                                    <input type="text" class="form-control" name="name" value="{{ $data->name ?? old('name') }}">
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">密码</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="password" class="form-control" name="password" autocomplete="new-password">
                                @if(isset($data->id))
                                    留空代表不更改密码
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Email</label>
                            <div class="col-md-6 col-xs-12">
                                <input type="text" class="form-control" name="email" value="{{ $data->email ?? old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">角色</label>
                            <div class="col-md-6 col-xs-12">
                                @foreach($roles as $role)
                                    <input type="radio" name="roles" value="{{$role->id}}" @if($user_role->contains($role->id)) checked @endif >  {{$role->name}}<br>
                                @endforeach
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
