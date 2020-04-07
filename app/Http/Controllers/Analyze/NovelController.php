<?php


namespace App\Http\Controllers\Analyze;


use App\Http\Controllers\Controller;

class NovelController extends Controller
{
    public function index()
    {
        $list = ['list' => []];
        return view('analyze.novel_list',$list);
    }
}
