<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\MgtRequest;

class MgtController extends Controller
{
    /**
     * 商品情報一覧を表示する
     * 
     * @return view
     */
    public function showList()
    {
        $products = Product::all();

        return view('mgt.list', ['products' => $products]);
    }


    /**
     * 商品情報詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('mgts'));
        }

        return view('mgt.detail', ['product' => $product]);
    }

    /**
     * 商品情報登録を表示する
     * 
     * @return view
     */

    public function showCreate() {
        return view('mgt.form');
    }

    /**
     * 商品を登録する
     * 
     * @return view
     */

    public function exeStore(MgtRequest $request) 
    {
        //商品情報のデータを受け取る
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            //商品情報を登録
              Product::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
       
        \Session::flash('err_msg', '商品を登録しました');
        return redirect(route('mgts'));
    }
}
