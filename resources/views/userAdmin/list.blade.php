@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>用户管理</li>
@endsection

@section('pageTitle')
@endsection
@inject('auth_validate', 'App\Service\AuthValidate')
@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-inline">
                        <div class="form-group">
                            <label>用户名:
                                <input type="text" class="form-control " autocomplete="off" name="name" value="{{$name or null}}">
                            </label>

                            <label>用户邮箱:
                                <input type="text" class="form-control " autocomplete="off" name="email" value="{{$email or null}}">
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">搜索</button>
                    </form>
                    <div class="form-inline">
                        <label class="col-md-10"></label>
                        <a href="{{ url('admin_user/edit') }}">
                            <button type="button" class=" btn-sm btn-success">新增用户</button>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户名</th>
                                <th>邮箱</th>
                                <th>角色</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ isset($item->name) ? $item->name : '佚名' }}</td>
                                    <td>{{ isset($item->email) ? $item->email : '暂未填写'}}</td>
                                    <td>{{ isset($item->roleUser) ? $item->roleUser->implode('role.name',','): '暂未分配'}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <a href="{{ url('admin_user/edit') }}?id={{$item->id}}" class="btn btn-sm btn-info">
                                            <span class="glyphicon glyphicon-edit"></span> 编辑
                                        </a>
                                        @if($auth_validate->authRouterValidate('admin_user.delete_user'))
                                        <span class="btn btn-sm btn-danger show-audit-information"  @if($user_id!=$item->id) onclick="deleteUser({{$item->id}})" @else disabled @endif >删除 </span>
                                        @endif
                                        @if($auth_validate->authRouterValidate('admin_user.change_status') && $user_id!=$item->id)
                                            @if($item->freeze==1)
                                                <span class="btn btn-sm btn-success show-audit-information" onclick="changeUserStatus({{$item->id}},{{$item->freeze}})">解冻</span>
                                            @else
                                                <span class="btn btn-sm btn-danger show-audit-information" onclick="changeUserStatus({{$item->id}},{{$item->freeze}})">冻结</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                没有用户
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="float: right">
                    {{ $list->appends($_GET)->links() }}
                </div>
            </div>
            <!-- END DEFAULT DATATABLE -->
        </div>
    </div>
@endsection

@section('js')
    <script>
        function deleteUser(id) {
            //询问框
            layer.confirm('确定要删除该用户吗？', {
                btn: ['确定', '取消'], //按钮
                area: ['320px', '186px'],
                skin: 'demo-class'
            }, function () {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: "delete",
                    dataType: "json",
                    url: '/admin_user/delete_user/'+id,
                    success: function (res) {
                        console.log(res)
                        location.reload();
                    }
                });
            }, function () {

            });
        }
        function changeUserStatus(id,freeze) {
          //询问框
          if(freeze==0){
            var news='确定要冻结该用户吗？';
          }else {
            var news='确定要解冻该用户吗？';
          }
          layer.confirm(news, {
            btn: ['确定', '取消'], //按钮
            area: ['320px', '186px'],
            skin: 'demo-class'
          }, function () {
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              type: "post",
              dataType: "json",
              url: '/admin_user/change_status/'+id,
              success: function (res) {
                console.log(res)
                location.reload();
              }
            });
          }, function () {

          });
        }
    </script>
@endsection
