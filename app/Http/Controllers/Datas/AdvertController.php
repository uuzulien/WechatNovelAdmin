<?php


namespace App\Http\Controllers\Datas;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvertController extends Controller
{
    public function index()
    {
        $list = ['list' => []];
        return view('datas.advert.list',$list);
    }

    public function addMoney(Request $request)
    {
        $cost = $request->input('stat_cost');
        $book_id = $request->input('book_id');
        DB::connection('admin')->table('grab_launch')->updateOrInsert(array('book_id' => $book_id), array('stat_cost' => $cost));

        return redirect('datas_collect/novel_list?page='.$request->input('page'));
    }
}
