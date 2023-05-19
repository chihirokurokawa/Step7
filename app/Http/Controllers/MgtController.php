<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\MgtRequest;
use Config;
use Illuminate\Support\Facades\Session;


class MgtController extends Controller
{
    /**
     * 商品情報一覧を表示する
     * 
     * @return view
     */
    // public function showList()
    // {
    //     $products = (new Product())->getProducts();
    //     $companies = (new Company())->getCompanies();
    //     $product_sort = request()->input('sort', null);
    //     return view('mgt.list', ['products' => $products, 'companies' => $companies]);
    // }

    public function showList(Request $request)
    {
        $sortColumn = $request->get('sort', 'id');  // クエリパラメータからカラム名を取得
        $sortDirection = $request->get('direction', 'asc');  // クエリパラメータから並び順を取得

        $products = (new Product())->getProducts();
        // $products = (new Product())->getSortedProducts($sortColumn, $sortDirection);
        $companies = (new Company())->getCompanies();
        // dd($companies);
        return view('mgt.list', ['products' => $products],['companies' => $companies]);
    }

    /**
     * 検索結果の表示
     * 
     * @return view
     */
    public function keyword(Request $request)
    {    
        $product_keyword = $request->input('product_keyword');
        $company_keyword = $request->input('company_keyword');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');
        $stock_min = $request->input('stock_min');
        $stock_max = $request->input('stock_max');
        $products = (new Product)->searchProducts($product_keyword, $company_keyword, $price_min, $price_max, $stock_min, $stock_max);
        $companies = (new Company())->getCompanies();

        // dd($companies);

        return view('mgt.list', ['products' => $products],['companies' => $companies]);
        // return view('mgt.list', compact($product_keyword, $company_keyword, $price_min, $price_max, $stock_min, $stock_max));

    }


    /**
     * 商品情報詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        // $product = Product::with('company:id,company_name')->find($id);
        $product = (new Product())->getProductById($id);

        if (is_null($product)) {
            \Session::flash('err_msg', \Config('messages.not_found'));
            return redirect(route('mgts'));
        }
        return view('mgt.detail', ['product' => $product]);
    }

    /**
     * 商品情報登録画面を表示する
     * 
     * @return view
     */

    public function showCreate() 
    {
        $companies = (new Company())->getCompanies();
        return view('mgt.form',['companies' => $companies ]);
    }

    /**
     * 商品を登録する
     * 
     * @return view
     */

    public function exeStore(MgtRequest $request) 
    {
        // 商品情報のデータを受け取る
                // $inputs = $request->all();
        $data = $request->all(); 
                // if(request('img_path')){
                //     $original = request()->file('img_path')->getClientOriginalName();
                //     $name = date('Ymd_His').'_'.$original;
                //     $file = request()->file('img_path')->move('storage/images',$name);
                // }

        \DB::beginTransaction();
        try {
                //商品情報を登録
                // Product::create([
                //     'company_id'=> $request->company_id,
                //     'product_name'=> $request->product_name,
                //     'price'=> $request->price,
                //     'stock'=> $request->stock,
                //     'comment'=> $request->comment,
                //     'img_path' => $name
                // ]);
            Product::createProduct($data);
        
            \DB::commit(); 
        } catch(\Throwable $e) {

            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', \Config('messages.registered'));
        return redirect(route('mgts'));
    }
    
    /**
     * 商品編集フォームを表示する
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {
        $product = Product::getProductWithCompany($id);
        $companies = Company::getCompanies();

        if (is_null($product)) {
            \Session::flash('err_msg', \Config('messages.not_found'));
            return redirect(route('mgts'));
        }
        return view('mgt.edit', compact('product', 'companies'));
    }
    
     /**
     * 商品を更新する
     * 
     * @return view
     */

    public function exeUpdate(MgtRequest $request) 
    {
                // 商品情報のデータを受け取る
                // $inputs = $request->all();
       
        \DB::beginTransaction();
        try {
                //商品情報を更新
                // $product = Product::find($inputs['id']);
                // $img_path = $request->img_path;
                // if(!is_null($request['img_path'])){
                //     $original = request()->file('img_path')->getClientOriginalName();
                //     $name = date('Ymd_His').'_'.$original;
                //     $file = request()->file('img_path')->move('storage/images',$name);
                //     $product -> img_path = $name;
                // }
                // $product ->fill([
                //     'product_name' => $inputs['product_name'],
                //     'company_id' => $inputs['company_id'],
                //     'price' => $inputs['price'],
                //     'stock' => $inputs['stock'],
                //     'comment' => $inputs['comment'],
                //     ]);
                // $product->save();

            Product::updateProduct($request);

           \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            \Log::error($e);
            
            // フロントにエラーを通知
            throw $e;
        }
        \Session::flash('err_msg', \Config('messages.updated'));
        return redirect(route('mgts'));
    }

    /**
     * 商品情報削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id)
    {
        if (empty($id)) {
            \Session::flash('err_msg', \Config('messages.not_found'));
            return redirect(route('mgts'));
        } try {
            //ブログを削除
            Product::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }
        \Session::flash('err_msg', \Config('messages.deleted'));
        return redirect(route('mgts'));
    }

}