<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
    //HomeController.phpが呼び出された際にユーザーがログイン済みかどうかをチェックしている。
    //コントローラーの__constructで設定する場合はすべてのアクションの実行前にログイン状態を確認できる。
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
