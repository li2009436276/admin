<?php


namespace Admin\Controllers;

use Illuminate\Support\Facades\Session;

class IndexController
{

    public function __construct(){

    }

    /**
     * 操作台
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(){

        return view('index.index');
    }
}