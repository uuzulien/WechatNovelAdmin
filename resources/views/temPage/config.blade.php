@extends('layouts.app')
<link href="{{ asset('css/summernote/summernote.min.css') }}" rel="stylesheet">
@section('breadcrumb')
    <li><a href="{{ route('home') }}">首页</a></li>
    <li>二跳模板</li>
@endsection

@section('pageTitle')
    <div class="page-title">
        <h2>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_article" style="width: 78px;height: 30px;">
                <span class="glyphicon glyphicon-plus">添加</span>
            </button>

        </h2>
        @include('popup.temPage.index')

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">

            <!-- START DEFAULT DATATABLE -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>模版名称</th>
                                <th>备注</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $key => $item)
                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->msg}}</td>
                                    <td>{{$item->updated_at}}</td>
                                    <td>

                                        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#add_article" data-key="{{$key}}">预览</button>
                                        <span class="btn btn-sm btn-danger show-audit-information" onclick="deletePage({{$item->id  }})" >删除 </span>

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
    <script type="text/javascript" src="{{ asset('js/summernote/summernote.js') }}"></script>

    <script type="text/javascript">
        var datas = @json($list)['data']
        // 编辑逻辑
        var option = $("select[name='book_id']");
        $('#add_article').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('key');
            var data = datas[recipient];
            var option_content = '';
            option_data = [];
            var modal = $(this);
            if (data) {
                modal.find('.modal-title').text('编辑');
                modal.find('#tid').val(data.id);
                modal.find('#title').val(data.title);
                modal.find('#msg').val(data.msg);
                $('#summernote').summernote('code',data.content);
            } else {
                modal.find('.modal-title').text('添加二跳页面');
                modal.find('#title').val('');
                modal.find('#msg').val('');
                $('#summernote').summernote('code','');
            }

            // modal.find('#art').html(data.content);
            {{--modal.find('.modal-body #platform-nick').val(data.platform_nick);--}}
            {{--modal.find('.modal-body #platform-name').val(data.platform_name);--}}
            {{--modal.find('.modal-body #cost-time').val('{{request()->get('time_at')}}');--}}

            {{--for (var key in data.books_name) {--}}
            {{--    option_content += `<option value="${key}">${data.books_name[key]}</option>`;--}}
            {{--    option_data.push(data.books_cost[key]);--}}
            {{--}--}}
            {{--option.html(option_content); // 添加下拉框--}}
            {{--modal.find('.modal-body #stat-cost').val(option_data[0]);--}}

        });

        // 富文本编辑器 js
        //     var mybtn = function (context) {
        //         var ui = $.summernote.ui;
        //         // create button
        //         var button = ui.button({
        //             contents: '<i class="fa fa-child"/> submit',
        //             tooltip: '提交按钮',
        //             click: function () {
        //                 console.log($('#summernote').summernote('code'));    //  获取富文本编辑器的值
        //                 $('.test').append($('#summernote').summernote('code'));   //  富文本编辑器内容添加到指定标签
        //                 $('#summernote').summernote('code','');  //  清空富文本编辑框的内容
        //                 console.log('111111')
        //             }
        //         });
        //         return button.render();   // return button as jquery object
        //     };

        // $('#summernote').summernote('insertImage', url, function ($image){
        //     console.log(2827392739)
        //
        //     $image.css('width', $image.width() / 3);
        //
        //     $image.attr('data-filename', 'retriever');
        //
        // });
        function renew(){
            $('body').attr('class', 'modal-open');
        };
        $('#summernote').summernote({
            placeholder: 'Hello',
            minHeight: 400,
            maxHeight: 600,
            width:'100%',
            dialogsFade : true,// Add fade effect on dialogs
            dialogsInBody : true,// Dialogs can be placed in body, not in
            // summernote.
            disableDragAndDrop : false,// default false You can disable dragdialogsInBody

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

            // callbacks: {
            //     // onImageUpload的参数为files，summernote支持选择多张图片
            //     onImageUpload : function(files) {
            //         var $files = $(files);
            //
            //         // 通过each方法遍历每一个file
            //         $files.each(function() {
            //             var file = this;
            //             // FormData，新的form表单封装，具体可百度，但其实用法很简单，如下
            //             var data = new FormData();
            //
            //             // 将文件加入到file中，后端可获得到参数名为“file”
            //             data.append("file", file);
            //
            //             // ajax上传
            //             $.ajax({
            //                 data : data,
            //                 type : "POST",
            //                 url : url,// div上的action
            //                 cache : false,
            //                 contentType : false,
            //                 processData : false,
            //
            //                 // 成功时调用方法，后端返回json数据
            //                 success : function(response) {
            //                     // 封装的eval方法，可百度
            //                     var json = YUNM.jsonEval(response);
            //
            //                     // 控制台输出返回数据
            //                     YUNM.debug(json);
            //
            //                     // 封装方法，主要是显示错误提示信息
            //                     YUNM.ajaxDone(json);
            //
            //                     // 状态ok时
            //                     if (json[YUNM.keys.statusCode] == YUNM.statusCode.ok) {
            //                         // 文件不为空
            //                         if (json[YUNM.keys.result]) {
            //
            //                             // 获取后台数据保存的图片完整路径
            //                             var imageUrl = json[YUNM.keys.result].completeSavePath;
            //
            //                             // 插入到summernote
            //                             $this.summernote('insertImage', imageUrl, function($image) {
            //                                 // todo，后续可以对image对象增加新的css式样等等，这里默认
            //                             });
            //                         }
            //                     }
            //
            //                 },
            //                 // ajax请求失败时处理
            //                 error : YUNM.ajaxError
            //             });
            //         });
            //     }
            //
            // }

        });

        function deletePage(id) {
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
                    url: '/page/gdt/del/'+id,
                    success: function (res) {
                        console.log(res)
                        location.reload();
                    },
                    error(res){
                        console.log(res.responseJSON.msg)
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
