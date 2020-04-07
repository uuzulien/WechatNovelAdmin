<?php


namespace App\Http\Controllers\Datas;


use App\Http\Controllers\Controller;
use App\Models\NovelData\GrabBooksPage;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    // 小说数据管理首页
    public function index(Request $request, GrabBooksPage $grabBooksPage)
    {
        $param = $request->input();

        $data = $grabBooksPage->searchList($param);

        return view('datas.novel.list',$data);
    }

    // 小说id订单明细
    public function showBookIdOrdersList()
    {
        $book_id = request()->input();
        $data = (new GrabBooksPage())->showOrderDetail($book_id);

        return view('datas.novel.order_list',$data);
    }

    // 小说订单明细
    public function showOrdersList(Request $request)
    {
        $book_id = $request->input('book_id');
        $data = (new GrabBooksPage())->showOrderDetail($book_id);

        return view('datas.novel.order_list',$data);
    }
}
