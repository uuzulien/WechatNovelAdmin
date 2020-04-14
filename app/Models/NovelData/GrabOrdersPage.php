<?php

namespace App\Models\NovelData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GrabOrdersPage extends Model
{
    protected $connection = 'admin';
    protected $table = 'grab_orders_page';

    public function belongsToOrderPage()
    {
        return $this->belongsTo(GrabOrdersApi::class, 'book_user_id', 'book_user_id');
    }
    public function hasOneGrabBooksApi()
    {
        return $this->hasOne(GrabBooksApi::class, 'book_id', 'book_id');
    }
    public function getMoneyTotalAttribute($value)
    {
        return self::query()->where(['book_user_id' => $this->book_user_id,'recharge_status' => '已支付'])->sum('recharge_amount');
    }
    public function getUnMoneyTotalAttribute()
    {
        return self::query()->where(['book_user_id' => $this->book_user_id,'recharge_status' => '待支付'])->sum('recharge_amount');
    }
    public function getWechatNameAttribute()
    {
        return $this->belongsToOrderPage->nickname ?? ($this->belongsToOrderPage->openid ?? '-');
    }

    // 停用
    public function getCostData()
    {
        $query = DB::connection('admin')->table('grab_books_page as p1')
            ->leftJoin('grab_books_api as b', function ($join) {
                $join->on('p1.book_id', '=', 'b.book_id');
            })->leftJoin('grab_orders_page as d1', function ($join) {
                $join->on('p1.book_id', '=', 'd1.book_id');
            })->leftJoin('grab_launch as u', function ($join) {
                $join->on('p1.book_id', '=', 'u.book_id');
            })->select(['p1.id', 'p1.book_id', 'd1.recharge_amount', 'p1.book_create_time',
                'u.stat_cost', 'b.user_follow_amount', 'b.click_num', 'd1.recharge_status'])->orderBy('book_create_time', 'desc')->get();

        $list = $query->groupBy('book_id')->map(function ($value) {
            $value['book_create_time'] = $value->first()->book_create_time ?? null;
            $start_time = Carbon::parse($value['book_create_time'])->startOfMonth()->toDateString();
            $end_time = Carbon::parse($value['book_create_time'])->endOfMonth()->toDateString();

            $item['book_create_time'] = $start_time . '~' .$end_time;
            $item['stat_cost'] = $value->first()->stat_cost ?? null;
            $item['recharge_amounts'] = $value->where('recharge_status','已支付')->sum('recharge_amount') ?? null; // 已支付的金额
            $item['user_follow_amount'] = $value->first()->user_follow_amount ?? null; // 新增粉丝
            $item['click_nums'] = $value->first()->click_num ?? null; // 点击量
            return $item;
        })->groupBy('book_create_time')->map(function ($value) {
            $item['stat_cost'] = $value->sum('stat_cost') ?? null;
            $item['recharge_amounts'] = $value->sum('recharge_amounts') ?? null; // 已支付的金额
            $item['user_follow_amount'] = $value->sum('user_follow_amount') ?? null; // 新增粉丝
            $item['click_nums'] = $value->sum('click_nums') ?? null; // 点击量
            $item['recover_cost'] = $item['stat_cost'] ? round(($item['recharge_amounts'] / $item['stat_cost']) * 100, 2) .'%' : 0; // 回本率
            $item['fens_cost'] = $item['stat_cost'] ? round(($item['stat_cost'] / $item['user_follow_amount']), 2) : 0; // 粉单价
            $item['click_cost'] = $item['stat_cost'] ? round(($item['stat_cost'] / $item['click_nums']), 2) : 0; // 点击单价
            return $item;
        });

        $total['cost_all'] = $list->sum('stat_cost');
        $total['money_all'] = $list->sum('recharge_amounts');
        $total['all_follow_amount'] = $list->sum('user_follow_amount');
        $total['recover_all'] = $total['cost_all'] ? round(($total['money_all'] / $total['cost_all']) * 100, 2) .'%' : 0; // 回本率
        $total['fens_all'] = $total['cost_all'] ? round(($total['cost_all'] / $total['all_follow_amount']), 2) : 0; // 粉单价

        return compact('list','total');

    }
}
