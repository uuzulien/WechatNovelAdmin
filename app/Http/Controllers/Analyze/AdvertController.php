<?php


namespace App\Http\Controllers\Analyze;


use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\NovelData\GrabOrdersPage;

class AdvertController extends Controller
{
    public function index()
    {
        return view('analyze.adv_list');
    }

    // 成本数据分析页面
    public function showCostList(GrabOrdersPage $grabOrdersPage)
    {
        $data = $grabOrdersPage->getCostData();

        return view('analyze.cost_list', $data);
    }
}
