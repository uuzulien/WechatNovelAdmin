<div class="modal fade" id="add_article" tabindex="-1" role="dialog" aria-labelledby="checkModalLabel" onclick="renew()">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">添加二跳页面</h4>
            </div>
            <form class="form-horizontal" method="post" action="{{route('temp.gdt.add')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">模版名称:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input id="title" class="form-control" name="title" type="text">
                            <input id="tid" class="form-control" name="id" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">模版内容:</label>
                        <div class="col-xs-12 col-sm-8">
                            <textarea type="text"  name="content" id="summernote"></textarea>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">备注:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input id="msg" class="form-control" name="msg" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </form>

        </div>
    </div>
</div>

