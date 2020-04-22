<?php


namespace App\Http\Controllers\Analyze;


use App\Http\Controllers\Controller;
use App\Models\NovelData\GrabOrdersApi;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    // 每月趋势付费
    public function index(Request $request,GrabOrdersApi $grabOrdersApi)
    {
        $param = $request->all();
        $data = $grabOrdersApi->getPayTrendData($param);
        return view('analyze.pay_trend', $data);
    }

    // 成本数据分析页面
    public function showCostList(GrabOrdersApi $grabOrdersApi,Request $request)
    {
        $param = $request->all();
        $data = $grabOrdersApi->getCostData($param);

        return view('analyze.cost_list', $data);
    }

    // 趋势付费明细
    public function detailPayTrend(Request $request,GrabOrdersApi $grabOrdersApi)
    {
        $param = $request->all();
        $data = $grabOrdersApi->getPayTrendDetail($param);
        return view('analyze.detail.pay_trend', $data);
    }
}
