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
        

        // $products = \DB::table('products')
        // ->join('companies','products.company_id','=','companies.id')
        // ->get();

        $products = \DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
        ->select('products.id','img_path','product_name','price','stock','company_name')
        ->get();
        
        return view('mgt.list', ['products' => $products]);
        
        //$companies = Company::where('company_id', Company::id())
        // $products = Product::with('company')->where('id, $id')->first();
        // return view ('mgt.list')->with('product','$product');

    }


    /**
     * 商品情報詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {

        $product = Product::with('company:id,company_name')->find($id);
       

        if (is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('mgts'));
        }

        // dd($product);
        
        return view('mgt.detail', ['product' => $product]);
    }

    /**
     * 商品情報登録画面を表示する
     * 
     * @return view
     */

    public function showCreate() {

        $companies = \DB::table('companies')
        ->select('id','company_name')
        ->get();
    
        return view('mgt.form',['companies' => $companies ]);
    }

    
    /**
     * 商品を登録する
     * 
     * @return view
     */

    public function exeStore(MgtRequest $request) 
    {
        // dd($request->all());
        // 商品情報のデータを受け取る
        $inputs = $request->all();
        


        \DB::beginTransaction();
        try {
            //商品情報を登録
            Product::create($inputs);
           \DB::commit();
        // } catch(Exception $e) {
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }


        \Session::flash('err_msg', '商品を登録しました');
        return redirect(route('mgts'));
        
    }
    
    /**
     * 商品編集フォームを表示する
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {

        $product = Product::with('company:id,company_name')->find($id);
        $companies = \DB::table('companies')
        ->select('id','company_name')
        ->get();

        // $products = \DB::table('products')
        // ->join('companies','products.company_id','=','companies.id')
        // ->select('products.id','img_path','product_name','price','stock','company_name')
        // ->get();

        if (is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('mgts'));
        }

        return view('mgt.edit',['product' => $product],['companies' => $companies ]);
    }
   

     /**
     * 商品を更新する
     * 
     * @return view
     */

    public function exeUpdate(MgtRequest $request) 
    {
        // dd($request->all());
        // 商品情報のデータを受け取る
        $inputs = $request->all();
        dd($inputs);

        \DB::beginTransaction();
        try {
            //商品情報を更新
            $product = Product::find($inputs['id']);
            $product ->fill([
                'product_name' => $inputs['product_name'],
                'company_id' => $inputs['company_id'],
                'price' => $inputs['price'],
                'stock' => $inputs['stock'],
                'comment' => $inputs['comment'],
                'img_path' => $inputs['img_path'],
            ]);
            $products->save();
           \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }


        \Session::flash('err_msg', '商品情報を更新しました');
        return redirect(route('mgts'));
        
    }


}

