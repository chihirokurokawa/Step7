<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
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
    
        $products = \DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
        ->select('products.id','img_path','product_name','price','stock','company_name')
        ->get();

        $companies = \DB::table('companies')
        ->select('id','company_name')
        ->get();
        

        
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

        // $products = \DB::table('products')
        // ->join('companies','products.company_id','=','companies.id')
        // ->select('products.id','img_path','product_name','price','stock','company_name')
        // ->get();

        $query = Product::query();

        if(!empty($product_keyword)) {
            $query->where('product_name', 'LIKE', "%{$product_keyword}%");
        }
        if(!empty($company_keyword)) {
            $query->where('company_name', 'LIKE', $company_keyword);
        }
        
        // $products_list = $query->get();

        // $companies_list = Company::all();

        $products = $query->get();

        $companies = \DB::table('companies')
        ->select('id','company_name')
        ->get();

        // dd($companies);

        return view('mgt.post', compact($products, $companies));

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


        if(request('img_path')){
            $original = request()->file('img_path')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $file = request()->file('img_path')->move('storage/images',$name);
            // $inputs -> img_path = $name;
        }
         
            \DB::beginTransaction();
        try {
            //商品情報を登録
            // Product::create($inputs);
             Product::create([
                    'company_id'=> $request->company_id,
                    'product_name'=> $request->product_name,
                    'price'=> $request->price,
                    'stock'=> $request->stock,
                    'comment'=> $request->comment,
                    'img_path' => $name
                ]);
            
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
        // $product = Product::find($id);
    
        $companies = \DB::table('companies')
        ->select('id','company_name')
        ->get();

        // $companies = Product::with('Company')->where('id', $id)->first();

        // $products = \DB::table('products')
        // ->join('companies','companies.id','=','products.company_id')
        // ->select('products.id','img_path','product_name','price','stock','company_name','comment')
        // ->get();

        // $products = \DB::table('products')
        // ->join('companies','companies.id','=','products.company_id')
        // ->get();

        // dd($product);
        // dd($companies);
        // if (isset($data['icon_image_path'])) {
        //     $icon_image_path = $data['icon_image_path']->store('img', 'public');
        // } else {
        //     $icon_image_path = "img/profile.jpg"; // nullからimg/profile.jpgに変更
        // }


        if (is_null($product)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('mgts'));
        }

        return view('mgt.edit')->with('product',$product)->with('companies',$companies);
        // return view('mgt.edit',['product' => $product],['products' => $products ],['companies' => $companies ]);
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
        // dd($inputs);

        \DB::beginTransaction();
        try {
            //商品情報を更新
            $product = Product::find($inputs['id']);
            $img_path = $request->img_path;

//             if(!is_null($name)){
//                 $original = request()->file('img_path')->getClientOriginalName();
//                 $name = date('Ymd_His').'_'.$original;
//                 $file = request()->file('img_path')->move('storage/images',$name);
//                 // $inputs -> img_path = $name;
// 
//                 // 画像の拡張子を取得
//                 $original = $request->file('img_path')->getClientOriginalName();
//                 // 画像の名前を取得
//                 $name = date('Ymd_His').'_'.$original;
//                 $file = request()->file('img_path')->move('storage/images',$name);
//                 // // 画像をリサイズ変更したところ
//                 // $width = 500;
//                 // $resize_img = Image::make($file)->resize($width, null, function($constraint){
//                 // $constraint->aspectRatio();
//                 // });
//                 $product -> img_path = $file;
//                 $product -> save();
//             }

            // if ($request->hasFile('img_path') && $request->file('img_path')->getClientOriginalName()){
            //     $name = date('Ymd_His').'_'.$original;
            //     $file = request()->file('img_path')->move('storage/images',$name);
            //     $file -> img_path = $name;
            // }
            //     $name -> save();

                if(!is_null($request['img_path'])){
                    $original = request()->file('img_path')->getClientOriginalName();
                    $name = date('Ymd_His').'_'.$original;
                    $file = request()->file('img_path')->move('storage/images',$name);
                    // $inputs -> img_path = $name;
                    $product -> img_path = $name;
                }
            
            
            $product ->fill([
                'product_name' => $inputs['product_name'],
                'company_id' => $inputs['company_id'],
                'price' => $inputs['price'],
                'stock' => $inputs['stock'],
                'comment' => $inputs['comment'],
                // 'img_path' => $name,
                
            ]);
            $product->save();

           \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            \Log::error($e);

            // フロントにエラーを通知
            throw $e;
        }


        \Session::flash('err_msg', '商品情報を更新しました');
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
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('mgts'));
        } try {
            //ブログを削除
            Product::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }
        
        // $product = Product::with('company:id,company_name')->find($id);
        
        \Session::flash('err_msg', '削除しました。');
        return redirect(route('mgts'));
    }

    

}

