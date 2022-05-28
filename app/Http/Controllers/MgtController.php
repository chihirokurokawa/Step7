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
       
        
        // $products = Product::all();
        $products = \DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
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
     * 商品情報登録を表示する
     * 
     * @return view
     */

    public function showCreate() {

        $companies = config('pull.company_name');
        
        return view('mgt.form',['companies' => $companies]);
    }

    
    /**
     * 商品を登録する
     * 
     * @return view
     */

    public function exeStore(MgtRequest $request) 
    {
        // dd($request->all());
        //商品情報のデータを受け取る
        $inputs = $request->all();
        // 商品情報の登録
        Product::create($inputs);

        // リレーション ここのエラー
        // $products = \DB::table('products')
        // ->join('products','companies.id','=','products.company_id')
        // ->get();
        
        // $products = \DB::table('products')
        // ->join('companies','products.company_id','=','companies.id')
        // ->get();

        $product = new App\Product(['company_name','id' => 'prpducts','company_id']);
        $company = App\Company::find(1);
        $company->products()->save($product);
        
        
        \DB::beginTransaction();
        try {
            //商品情報を登録
            Product::create($inputs);
           \DB::commit();
        // } catch(Exception $e) {
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
            // echo "例外キャッチ：",$e->getMessage(),"\n";
            
        }

        \Session::flash('err_msg', '商品を登録しました');

        
        return redirect(route('mgts'));
    
        // コミットテスト
        
    }
}
