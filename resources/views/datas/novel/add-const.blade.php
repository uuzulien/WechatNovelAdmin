<div class="modal fade" id="add_const_{{$item->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="layui-layer layui-layer-page" id="layui-layer1" type="page"
                 times="1" showtime="0" contype="string" style="z-index: 19891015; width: 800px; height: 600px; top: 160px; left: 88px;">
                <div class="layui-layer-title" style="cursor: move;">
                    编辑
                </div>
                <div id="" class="layui-layer-content" style="height: 558px;">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form class="form-horizontal" method="post" action="{{route('datas.adv.add_money')}}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            在投公众号
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$item->platform_nick}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            平台
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$item->platform_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            小说名
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$item->book_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control"  name="book_id" value="{{$item->book_id}}">
                                        <input type="hidden" class="form-control"  name="page" value="{{request()->get('page')}}">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label form-label">
                                            推广成本
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="stat_cost" name="stat_cost" value="{{$item->stat_cost}}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
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
