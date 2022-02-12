<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MgtController extends Controller
{
    /**
     * 商品情報一覧を表示する
     * 
     * @return view
     */
    public function showList()
    {
        return view('mgt.list');
    }

}
