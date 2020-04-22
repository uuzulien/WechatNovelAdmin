<div class="modal fade" id="add_article" tabindex="-1" role="dialog" aria-labelledby="checkModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">添加二跳页面</h4>
            </div>
            <form class="form-horizontal" method="post" action="{{route('page.gdt.add')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">公众号名称:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input id="wechatnamecn" class="form-control" name="wechatnamecn" type="text">
                            <input id="cid" class="form-control" name="id" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">公众号英文名称:</label>
                        <div class="col-xs-12 col-sm-8">
                            <input id="wechatnameen" class="form-control" name="wechatnameen" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">文件名(允许字母和数字):</label>
                        <div class="col-xs-12 col-sm-8">
                            <input id="wid" class="form-control" name="wid" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">模版内容:</label>
                        <div class="col-xs-12 col-sm-8">
                            <select class="form-control" autocomplete="off" id="page_id" name="page_id">
{{--                                <option value="">请选择模板</option>--}}
                            </select>
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

