@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>小说账户配置</li>
@endsection

@section('pageTitle')
    <div class="page-title">
        <h2>
            <button
               class="btn btn-sm btn-primary refuse" data-toggle="modal" data-target="#amendModal">
                <span class="glyphicon glyphicon-plus"></span> 新增账号
            </button>
        </h2>

    </div>
@endsection

@section('content')
    @include('popup.amend.account_config')
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-inline">
                        <div class="form-group">
                            <select id="keyword" class="form-control" autocomplete="off" name="key">
                                    <option value="pfname" @if(request()->get('key')=='pfname') selected @endif>平台名称</option>
                                    <option value="account" @if(request()->get('key')=='account') selected @endif>账号</option>
                            </select>
                            <label>
                                <input type="text" class="form-control" autocomplete="off" name="word" value="{{request()->get('word')}}" placeholder="选择名称或账号">
                            </label>
                        </div>
                        <div class="form-group">
                            <label>平台:</label>
                            <select id="select-id" class="form-control" autocomplete="off" name="pt_type">
                                <option value="0" >所有平台</option>
                                @foreach($platforms as $key => $value)
                                    <option value="{{$key}}" @if(request()->get('pt_type')==$key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>账户状态: </label>
                            <select id="select-id" class="form-control" autocomplete="off" name="status">
                                    <option value="0" >所有状态</option>
                                    <option value="1" @if(request()->get('status')=='1') selected @endif>正常</option>
                                    <option value="2" @if(request()->get('status')=='2') selected @endif>异常</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">搜索</button>
                    </form>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>平台名称</th>
                                <th>账户</th>
                                <th>密码</th>
                                <th>所属平台</th>
                                <th>操作人</th>
                                <th>状态</th>
                                <th>备注</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $key => $item)
                                <tr>
                                    <td>{{ $item['platform_nick'] }}</td>
                                    <td>{{ $item['account']}}</td>
                                    <td>{{ $item['password'] }}</td>
                                    <td>{{ $item->platform}}</td>
                                    <td>{{ $item->operator}}</td>
                                    <td @if($item['status'] == '2') style="color: red;" @endif>{{ [0=>'初始化',1=>'正常', 2 => '异常'][$item['status']]}}</td>
                                    <td>{{ $item->msg }}</td>
                                    <td>{{ $item['created_at']}}</td>
                                    <td>{{ $item['updated_at'] }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#amendModal" data-key="{{$key}}">修改</button>
                                        <span class="btn btn-sm btn-danger show-audit-information" onclick="deleteAccount({{$item->id  }})" >删除 </span>
                                    </td>
                                </tr>
                            @empty
                                没有数据
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page">{{$list->appends($app->request->all())->links()}}</div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        var datas = @json($list)['data'];
        var platforms = @json($platforms);
        // 编辑逻辑
        var option = $("select[name='pt_type']");
        $('#amendModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('key');
            var data = datas[recipient];
            var option_content = '';
            option_data = [];

            var modal = $(this);
            if (data) {
                modal.find('#exampleModalLabel').text('修改账号');
                modal.find('#pfname').val(data.platform_nick);
                modal.find('#username').val(data.account);
                modal.find('#passwd').val(data.password);
                modal.find('#cid').val(data.id);
                modal.find('#act').attr('action',"{{route('account.config.amend')}}");
            } else {
                modal.find('#exampleModalLabel').text('添加账号');
                modal.find('#pfname').val('');
                modal.find('#username').val('');
                modal.find('#passwd').val('');
                modal.find('#act').attr('action',"{{route('account.add_novel')}}");
            }


            for (var key in platforms) {
                option_content += `<option value="${key}">${platforms[key]}</option>`;
                option_data.push(platforms[key]);
            }
            option.html(option_content); // 添加下拉框
        });
        // 删除账号
        function deleteAccount(id) {
            //询问框
            layer.confirm('确定要删除该项吗？', {
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
                    url: '/account/config/del/'+id,
                    success: function (res) {
                        console.log(res);
                        layer.msg('操作成功', {
                            icon: 1,
                            time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){
                            location.reload();
                        });
                    },
                    error(res){
                        console.log(res.responseJSON.msg);
                        layer.open({
                            title:false,
                            content:'<span>'+res.responseJSON.msg+'</span>',
                            btn:false,
                            time:3000,
                            closeBtn:0,
                        });
                    }
                });
            }, function () {

            });
        }
    </script>
@endsection
