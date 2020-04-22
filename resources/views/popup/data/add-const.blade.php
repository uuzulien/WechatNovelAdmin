<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">编辑</h4>
            </div>
            <form class="form-horizontal" method="post" action="{{route('datas.adv.add_money')}}">
                {{ csrf_field() }}
            <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">投放时间:</label>
                        <input type="text" class="form-control" id="cost-time" name="cost_time" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">在投公众号:</label>
                        <input type="text" class="form-control" id="platform-nick" name="platform_nick" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">平台:</label>
                        <input type="text" class="form-control" id="platform-name" name="platform_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">小说名:</label>
                        <select class="form-control" autocomplete="off" name="book_id">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">推广成本:</label>
                        <input type="text" class="form-control" id="stat-cost" name="stat_cost">
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
