@extends('layouts.app')
<style type="text/css">
    .editor_wrap {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        /* z-index: 10; */
        background: rgba(0,0,0,0.5);
        display: none;
    }
    .editor_con {
        background: #fff;
        width: 740px;
        /* height: 600px; */
        padding: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>小说数据分析</li>
@endsection

@section('pageTitle')
{{--    <div class="page-title">--}}
{{--        <h2>--}}
{{--            <button--}}
{{--                class="btn btn-sm btn-primary refuse" data-toggle="modal" data-target="#add_account">--}}
{{--                <span class="glyphicon glyphicon-plus"></span> 新增账号--}}
{{--            </button>--}}

{{--        </h2>--}}
{{--        @include('novel.add-account')--}}

{{--    </div>--}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-inline">
                        <div class="form-group">
{{--                            <label>--}}
{{--                                <select id="keyword" class="compensatory-style pay_status_style" autocomplete="off" name="key">--}}
{{--                                    <option value="pfname" @if(request()->get('key')=='pfname') selected @endif>平台名称</option>--}}
{{--                                    <option value="account" @if(request()->get('key')=='account') selected @endif>账号</option>--}}
{{--                                </select>--}}
{{--                                <input type="text" class="user-name-style" autocomplete="off" name="word" value="{{request()->get('word')}}">--}}
{{--                            </label>--}}
                            <label>平台:
                                <select id="select-id" class="compensatory-style pay_status_style" autocomplete="off" name="pt_type">
                                    <option value="0" >所有平台</option>
                                    <option value="1" >掌读</option>
                                </select>
                            </label>
                            <label>账户状态:
                                <select id="select-id" class="compensatory-style pay_status_style" autocomplete="off" name="status">
                                    <option value="0" >所有状态</option>
                                    <option value="1" @if(request()->get('status')=='1') selected @endif>正常</option>
                                    <option value="2" @if(request()->get('status')=='2') selected @endif>异常</option>
                                </select>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-default">搜索</button>
                    </form>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>发文时间</th>
                                <th>派单人</th>
                                <th>派单详情</th>
                                <th>派单公众号</th>
                                <th>阅读详情</th>
                                <th>小说id</th>
                                <th>小说名</th>
                                <th>平台</th>
                                <th>数据更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="btn_editor">点击弹出编辑器</td>
                                </tr>
                            @forelse($list as $item)
                                <tr>
{{--                                    <td>{{ $item['platform_nick'] }}</td>--}}
{{--                                    <td>{{ $item['account']}}</td>--}}
{{--                                    <td>{{ $item['password'] }}</td>--}}
{{--                                    <td>{{ $item->platform}}</td>--}}
{{--                                    <td>{{ $item->operator}}</td>--}}
{{--                                    <td>{{ [1=>'正常', 2 => '异常'][$item['status']]}}</td>--}}
{{--                                    <td>{{ $item['created_at']}}</td>--}}
{{--                                    <td>{{ $item['updated_at'] }}</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="">--}}
{{--                                        <span class="btn btn-sm btn-info">--}}
{{--                                        查看详情--}}
{{--                                        </span>--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
                                </tr>
                            @empty
                                没有数据
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
{{--                <div class="page">{{$list->appends($app->request->all())->links()}}</div>--}}
                <div class="test"></div>
            </div>
            <!-- 弹窗---------------------------------富文本编辑器 -->
            <div id="summernote"></div>

        </div>
    </div>

@endsection

@section('js')

<script type="text/javascript">
    // 富文本编辑器 js
    var submit = function (context) {
        var ui = $.summernote.ui;
        // create button
        var button = ui.button({
            contents: '<i class="fa fa-child"/> submit',
            tooltip: '提交按钮',
            click: function () {
                console.log($('#summernote').summernote('code'));    //  获取富文本编辑器的值
                $('.test').append($('#summernote').summernote('code'));   //  富文本编辑器内容添加到指定标签
                $('#summernote').summernote('code','');  //  清空富文本编辑框的内容
                console.log('111111')
            }
        });
        return button.render();   // return button as jquery object
    }
    $('#summernote').summernote({
        placeholder: 'Hello',
        minHeight: 200,
        maxHeight: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']],
            ['submit',['submit']], // 自定义按钮
        ],
        buttons: {
            submit: submit
        }
    });
</script>

@endsection
