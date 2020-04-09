<?php

namespace App\Models\NovelData;

use App\Models\AdminUsers;
use App\Models\GroupUsers;
use Illuminate\Database\Eloquent\Model;
use App\Models\NovelAdv\PlatformManage;
use App\Models\NovelAdv\AccountManage;
use Illuminate\Support\Facades\Auth;

class GrabBooksPage extends Model
{
    protected $connection = 'admin';
    protected $table = 'grab_books_page';

    public function hasManyOrderPage()
    {
        return $this->hasMany(GrabOrdersPage::class, 'book_id', 'book_id');
    }
    public function hasOnePlatformManage()
    {
        return $this->hasOne(PlatformManage::class, 'id', 'pid');
    }
    public function hasOneGrabBooksApi()
    {
        return $this->hasOne(GrabBooksApi::class, 'book_id', 'book_id');
    }

    public function getPlatformNameAttribute()
    {
        return $this->hasOnePlatformManage->platform_name ?? '-';
    }

    public function getReadDetailAttribute()
    {
        $query = $this->hasOneGrabBooksApi;

        $click_num = $query->click_num ?? 0;
        $user_amount = $query->user_amount ?? 0;
        $order_paid = $query->order_paid ?? 0;
        $order_unpaid = $query->order_unpaid ?? 0;
        $user_follow_amount = $query->user_follow_amount ?? 0;

        $content = "
            点击量：$click_num
            <br>
            新增用户：$user_amount
            <br>
            已支付：$order_paid
            <br>
            未支付：$order_unpaid
            <br>
            关注数：$user_follow_amount
            <br>
        ";

        return $content;
    }

    public function getLaunchDetailAttribute()
    {
        $query = $this->hasOneGrabBooksApi;
        $user_follow_amount = $query->user_follow_amount ?? 0; // 关注数
        $click_num = $query->click_num ?? 0;

        $stat_cost = $this->stat_cost ?? 0;
        $money = $query->money ?? 0;
        $recover_cost = $stat_cost ? round(($money / $stat_cost) * 100, 2) .'%' : 0;
        $fens_cost = $user_follow_amount ? round(($stat_cost / $user_follow_amount), 2) : 0;
        $click_cost = $click_num ? round(($stat_cost / $click_num), 2) : 0;

        $recover_cost = $recover_cost > 1 ? '<b style="color: red">'. $recover_cost .'</b>' : $recover_cost;

        $content = "

            成本：$stat_cost
            <br>
            充值：$money
            <br>
            回本率：$recover_cost
            <br>
            粉价：$fens_cost
            <br>
            点击单价：$click_cost
            <br>

        ";

        return $content;
    }

    public function searchList($data)
    {
        $pid = $data['pt_type'] ?? null;
        $start_at = $data['start_at'] ?? null;
        $end_at = $data['end_at'] ?? null;

        $query = self::with(['hasManyOrderPage','hasOnePlatformManage','hasOneGrabBooksApi'])->orderBy('updated_at', 'desc')
            ->leftJoin('grab_launch as gl', function ($join) {
                $join->on('gl.book_id', '=', 'grab_books_page.book_id');
            })->leftJoin('account_config as ac', function ($join) {
                $join->on('ac.id', '=', 'grab_books_page.pt_id');
            })->leftJoin('admin_users as us', function ($join) {
                $join->on('us.id', '=', 'ac.user_id');
            })->select(['grab_books_page.*','gl.stat_cost', 'ac.user_id', 'ac.platform_nick', 'us.name']);

        $groups = (new GroupUsers())->where('group_id', Auth::id())->get()->pluck('user_id')->push(Auth::id());// 小组临时权限控制

        $list = $query->when(Auth::id()!= 1, function ($q) use($groups) {
                    $q->whereIn('user_id', $groups);
                })->when($pid ,function ($q) use($pid) {
                    $q->where('grab_books_page.pid', $pid);
                })->when($start_at, function ($q) use($start_at,$end_at) {
                    $q->whereBetween('book_create_time', [$start_at, $end_at]);
                })->paginate(15);

        $list->transform(function ($item){
            $item['has_order'] = $item->hasManyOrderPage->toArray() ? true: false ;
            return $item;
        });

        $platforms = (new PlatformManage())->where('type', '1')->get(['id','platform_name']);

        return compact('list','platforms');
    }

    // 获取订单明细
    public function showOrderDetail($book_id)
    {
        $query = GrabOrdersPage::query()->with(['belongsToOrderPage']);

        $list = $query->when($book_id, function ($q) use($book_id) {
                    $q->where(['book_id' => $book_id]);
                })->groupBy('book_user_id')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

        return compact('list');
    }


}
