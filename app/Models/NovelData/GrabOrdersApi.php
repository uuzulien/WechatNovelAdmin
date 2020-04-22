<?php

namespace App\Models\NovelData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Repositories\Auth\GroupPermission;
use App\Repositories\CarbonHand\HandleCore;
class GrabOrdersApi extends Model
{
    protected $connection = 'admin';
    protected $table = 'grab_orders_api';

    // 获取成本数据
    public function getCostData($data)
    {
        $pdr = $data['pdr'] ?? null;
        $queryGroup = new GroupPermission();

        $userGroup = $queryGroup->userGroup($pdr); // 权限组
        $groupTree = $queryGroup->getGroupTree($queryGroup->userGroup());// 权限树

        $query = DB::connection('admin')->table('grab_orders_api as op')
            ->join('grab_books_page as bg', function ($join) {
                $join->on('bg.book_id', '=', 'op.book_id')
                    ->on('bg.book_create_time', '<=', 'op.regtime');
            })->leftJoin('account_config as ac', function ($join) {
                $join->on('bg.pt_id', '=', 'ac.id');
            })->whereIn('ac.user_id', $userGroup)->leftJoin('grab_launch as u', function ($join) {
                $join->on('bg.book_id', '=', 'u.book_id')
                    ->whereRaw('DATE_FORMAT(op.regtime,"%Y-%m-%d") = DATE_FORMAT(u.cost_time,"%Y-%m-%d")');
            })->leftJoin('grab_orders_page as og', function ($join) {
                $join->on('op.book_user_id', '=', 'og.book_user_id');
            })->select(['op.regtime', DB::raw('DATE_FORMAT(op.regtime,"%Y-%m-%d") as daytime'), 'op.book_id','op.book_user_id',
                'u.cost_time','u.stat_cost', 'og.recharge_amount', 'og.recharge_status', 'ac.user_id'])
            ->orderBy('op.regtime', 'desc')->get();

        $list = $query->groupBy('book_user_id')->map(function ($value) {
            $value['book_create_time'] = $value->first()->regtime ?? null;
            $start_time = Carbon::parse($value['book_create_time'])->startOfMonth()->toDateString();
            $end_time = Carbon::parse($value['book_create_time'])->endOfMonth()->toDateString();
            $item['fens_day'] = $start_time . '~' .$end_time;

            $item['datas'] = $value;

            $item['book_user_id'] = $value->first()->book_user_id ?? null;
            $item['regtime'] = $value->first()->regtime ?? null;
            $item['cost_time'] = $value->first()->cost_time ?? null;
            $item['book_id'] = $value->first()->book_id ?? null;
            $item['stat_cost'] = $value->first()->stat_cost ?? null;
            $item['recharge_amounts'] = $value->where('recharge_status','已支付')->sum('recharge_amount') ?? null; // 已支付的金额
            return $item;
        })->groupBy('fens_day')->map(function($value) {
            $item_day = array(); // 默认空数组
            foreach ($value as $q) {
                foreach ($q['datas'] as $k => $v){
                    $sub_day = $v->daytime ?? null;
                    if ($sub_day) {
                        $item_day[$sub_day]['pay_time'] = $v->daytime;
                        $item_day[$sub_day]['today_moeny'] = ($item_day[$sub_day]['today_moeny'] ?? 0) + ($v->recharge_status == '已支付' ? $v->recharge_amount : 0);
                        $item_day[$sub_day]['stat_cost'][$v->book_id] = ($item_day[$sub_day]['stat_cost'][$v->book_id] ?? null) ?? $v->stat_cost;
                    }
                }
            }
            foreach ($item_day as $k => $v) {
                $item_day[$k]['stat_cost'] = array_sum($v['stat_cost']);
            }
            sort($item_day);
            $item['data'] = $item_day;
            $book_stat_cost = $value->groupBy(['book_id','cost_time'])->map(function ($value){
                return $value->map(function ($day_cost) {
                    return $day_cost->first()['stat_cost'] ?? null;
                })->sum();
            }); // 每本书每日的消耗
            $item['stat_cost'] = $book_stat_cost->sum() ?? null;
            $item['recharge_amounts'] = $value->sum('recharge_amounts') ?? null; // 已支付的金额
            $item['user_follow_amount'] = $value->count(); // 新增粉丝
            $item['recover_cost'] = $item['stat_cost'] ? round(($item['recharge_amounts'] / $item['stat_cost']) * 100, 2) .'%' : 0; // 回本率
            $item['fens_cost'] = $item['stat_cost'] ? round(($item['stat_cost'] / $item['user_follow_amount']), 2) : 0; // 粉单价
            return $item;
        });
        $total['cost_all'] = $list->sum('stat_cost');
        $total['money_all'] = $list->sum('recharge_amounts');
        $total['all_follow_amount'] = $list->sum('user_follow_amount');
        $total['recover_all'] = $total['cost_all'] ? round(($total['money_all'] / $total['cost_all']) * 100, 2) .'%' : 0; // 回本率
        $total['fens_all'] = $total['cost_all'] ? round(($total['cost_all'] / $total['all_follow_amount']), 2) : 0; // 粉单价

        return compact('list','total', 'groupTree');
    }

    // 趋势付费数据
    public function getPayTrendData($data)
    {
        $pdr = $data['pdr'] ?? null;
        $userGroup = (new GroupPermission())->userGroup($pdr);

        $start_at = $data['start_at'] ?? null;
        $end_at = $data['end_at'] ?? null;
        $query = DB::connection('admin')->table('grab_orders_api as op')
            ->join('grab_books_page as bg', function ($join) {
                $join->on('bg.book_id', '=', 'op.book_id')
                    ->on('bg.book_create_time', '<=', 'op.regtime');
            })->leftJoin('account_config as ac', function ($join) {
                $join->on('bg.pt_id', '=', 'ac.id');
            })->whereIn('ac.user_id', $userGroup)->leftJoin('grab_launch as u', function ($join) {
                $join->on('bg.book_id', '=', 'u.book_id')
                    ->whereRaw('DATE_FORMAT(op.regtime,"%Y-%m-%d") = DATE_FORMAT(u.cost_time,"%Y-%m-%d")');
            })->whereDate('op.regtime','>=',$start_at)->whereDate('op.regtime','<=',$end_at)
            ->leftJoin('grab_orders_page as og', function ($join) {
                $join->on('op.book_user_id', '=', 'og.book_user_id');
            })->select(['op.regtime', DB::raw('DATE_FORMAT(op.regtime,"%Y-%m-%d") as daytime'), 'op.book_id','op.book_user_id',
                'u.cost_time','u.stat_cost', 'og.recharge_amount', 'og.recharge_status','og.order_create_time', 'ac.user_id'])
            ->orderBy('op.regtime', 'desc')->get();

        $list = $query->groupBy('book_user_id')->map(function ($value) {
            $item['datas'] = $value->where('recharge_status','已支付');
            $item['book_user_id'] = $value->first()->book_user_id ?? null;
            $item['daytime'] = $value->first()->daytime ?? null;
            $item['cost_time'] = $value->first()->cost_time ?? null;
            $item['book_id'] = $value->first()->book_id ?? null;
            $item['stat_cost'] = $value->first()->stat_cost ?? null;
            $item['recharge_amounts'] = $value->where('recharge_status','已支付')->sum('recharge_amount') ?? null; // 已支付的金额
            return $item;
        })->groupBy('daytime')->map(function($value) {
            $item_day = array(); // 默认空数组
            foreach ($value as $q) {
                foreach ($q['datas'] as $k => $v){
                    $sub_day = Carbon::parse($v->order_create_time)->diffInDays($v->regtime);
                    $item_day[$sub_day]['pay_time'] = $sub_day + 1;
                    $item_day[$sub_day]['today_moeny'] = ($item_day[$sub_day]['today_moeny'] ?? 0) + $v->recharge_amount;
                }
            }
            $book_stat_cost = $value->groupBy('book_id')->map(function ($value){
                return $value->first()['stat_cost'];
            }); // 每本书每日的消耗
            sort($item_day);
            $item['data'] = $item_day;
            $item['stat_cost'] = $book_stat_cost->sum() ?? null;
            $item['recharge_amounts'] = $value->sum('recharge_amounts') ?? null; // 已支付的金额
            $item['user_follow_amount'] = $value->count(); // 新增粉丝
            $item['recover_cost'] = $item['stat_cost'] ? round(($item['recharge_amounts'] / $item['stat_cost']) * 100, 2) .'%' : 0; // 回本率
            return $item;
        });
        return compact('list');
    }

    // 获取付费趋势明细
    public function getPayTrendDetail($data)
    {
        $pdr = $data['pdr'] ?? null;
        $userGroup = (new GroupPermission())->userGroup($pdr);

        $time_at = $data['time_at'] ?? null;
        $query = DB::connection('admin')->table('grab_orders_api as op')
            ->whereDate('op.regtime',$time_at)
            ->join('grab_books_page as bg', function ($join) {
                $join->on('bg.book_id', '=', 'op.book_id')
                    ->on('bg.book_create_time', '<=', 'op.regtime');
            })->leftJoin('account_config as ac', function ($join) {
                $join->on('bg.pt_id', '=', 'ac.id');
            })->whereIn('ac.user_id', $userGroup)->leftJoin('grab_launch as u', function ($join) {
                $join->on('bg.book_id', '=', 'u.book_id')
                    ->whereRaw('DATE_FORMAT(op.regtime,"%Y-%m-%d") = DATE_FORMAT(u.cost_time,"%Y-%m-%d")');
            })->leftJoin('grab_orders_page as og', function ($join) {
                $join->on('op.book_user_id', '=', 'og.book_user_id');
            })->leftJoin('platform_config as pt', function ($join) {
                $join->on('ac.pid', '=', 'pt.id');
            })->select(['op.regtime', DB::raw('DATE_FORMAT(op.regtime,"%Y-%m-%d") as daytime'), 'op.book_id','op.book_user_id', 'pt.platform_name',
                'u.cost_time','u.stat_cost', 'og.recharge_amount', 'og.recharge_status','og.order_create_time', 'bg.pt_id', 'ac.platform_nick','bg.book_name', 'ac.user_id'])
            ->orderBy('op.regtime', 'desc')->get();

        $list = $query->groupBy('book_user_id')->map(function ($value) {
            $item['datas'] = $value->where('recharge_status','已支付');
            $item['book_user_id'] = $value->first()->book_user_id ?? null;
            $item['daytime'] = $value->first()->daytime ?? null;
            $item['cost_time'] = $value->first()->cost_time ?? null;
            $item['book_id'] = $value->first()->book_id ?? null;
            $item['pt_id'] = $value->first()->pt_id ?? null;
            $item['platform_nick'] = $value->first()->platform_nick ?? null;
            $item['book_name'] = $value->first()->book_name ?? null;
            $item['platform_name'] = $value->first()->platform_name ?? null;
            $item['stat_cost'] = $value->first()->stat_cost ?? null;
            $item['recharge_amounts'] = $value->where('recharge_status','已支付')->sum('recharge_amount') ?? null; // 已支付的金额
            return $item;
        })->groupBy('pt_id')->map(function($value) {
            $item_day = array(); // 默认空数组
            foreach ($value as $q) {
                foreach ($q['datas'] as $k => $v){
                    $sub_day = Carbon::parse($v->order_create_time)->diffInDays($v->regtime);
                    $item_day[$sub_day]['pay_time'] = $sub_day + 1;
                    $item_day[$sub_day]['today_moeny'] = ($item_day[$sub_day]['today_moeny'] ?? 0) + $v->recharge_amount;
                }
            }
            sort($item_day);
            $item['data'] = $item_day;
            $item['platform_nick'] = $value->first()['platform_nick'];
            $item['books_name'] = $value->pluck('book_name','book_id')->unique(); // 书籍标签
            $item['books_cost'] = $value->pluck('stat_cost','book_id')->unique(); // 书籍消耗
            $item['stat_cost'] = $item['books_cost']->sum(); // 获取所有书籍的消耗
            $item['platform_name'] = $value->first()['platform_name'] ?? '-';
            $item['recharge_amounts'] = $value->sum('recharge_amounts') ?? null; // 已支付的金额
            $item['user_follow_amount'] = $value->count(); // 新增粉丝
            $item['recover_cost'] = $item['stat_cost'] ? round(($item['recharge_amounts'] / $item['stat_cost']) * 100, 2) .'%' : 0; // 回本率
            return $item;
        });
        return compact('list');
    }
}
