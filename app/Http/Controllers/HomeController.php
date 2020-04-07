<?php
/**
 * Created by PhpStorm.
 * User: Mr Zhou
 * Date: 2020/3/22
 * Time: 1:24
 * Emali: 363905263@qq.com
 */
namespace App\Http\Controllers;


class HomeController extends Controller
{
    /**
     * 欢迎回家
     */
    public function index()
    {
        return view('home');
    }
}
