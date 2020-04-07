<?php


namespace App\Http\Controllers\SeekData\Web;


use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    // 基础配置页面
    public function index()
    {
        return view('seek.config.index');
    }

    // 配置清单页面
    public function showConfigList()
    {
        return view('seek.config.list');
    }
}
