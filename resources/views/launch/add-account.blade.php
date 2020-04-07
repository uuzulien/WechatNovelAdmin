<div class="modal fade" id="add_account">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="layui-layer layui-layer-page" id="layui-layer1" type="page"
                 times="1" showtime="0" contype="string" style="z-index: 19891015; width: 800px; height: 600px; top: 160px; left: 88px;">
                <div class="layui-layer-title" style="cursor: move;">
                    添加派单账号
                </div>
                <div id="" class="layui-layer-content" style="height: 558px;">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form class="form-horizontal" method="post" action="{{route('account.add_novel')}}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            平台名称
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pfname" name="pfname" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            平台来源
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="pt_type">
                                                <option value="0">
                                                    请选择
                                                </option>
                                                <option value="1">
                                                    巨量引擎
                                                </option>
                                                <option value="2">
                                                    其它
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            账号
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="username" name="username"
                                                   value=""  required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            密码
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="passwd" name="passwd" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            {{--                                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>--}}

                                            <button type="submit" class="btn btn-info" lay-submit lay-filter="formDemo">
                                                提交
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="layui-layer-setwin">
{{--                    <a class="layui-layer-min" href="javascript:;">--}}
                    {{--                        <cite>--}}
                    {{--                        </cite>--}}
                    {{--                    </a>--}}
                    {{--                    <a class="layui-layer-ico layui-layer-max" href="javascript:;">--}}
                    {{--                    </a>--}}
                    {{--                    <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;" data-dismiss="modal" lay-filter="formDemo">--}}
                    {{--                    </a>--}}
                </span>
                <span class="layui-layer-resize">
                </span>
            </div>
        </div>
    </div>
</div>
