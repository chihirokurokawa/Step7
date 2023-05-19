<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable; 

class Product extends Model
{
    use Sortable; 
    public $sortable = ['id', 'name', 'price'];

    //テーブル名　テーブルとモデルが紐ずく
    protected $table ='products';

    //可変項目
    protected $fillable =
    [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }
    public function getProducts()
    {
        $products = \DB::table('products')
        ->join('companies','products.company_id','=','companies.id')
        ->select('products.id','img_path','product_name','price','stock','company_name')
        ->get();
        return $products;
    }
    public function getCompanies()
    {
        $companies = \DB::table('companies')
        ->select('id','company_name')
        ->get();
        return $companies;
    }

//  public static function searchProducts($product_keyword, $company_keyword)
//     {
//         $query = DB::table('products')
//             ->join('companies', 'products.company_id', '=', 'companies.id')
//             ->select('products.id', 'img_path', 'product_name', 'price', 'stock', 'company_name');

//         if(!empty($product_keyword)) {
//             $query->where('product_name', 'LIKE', "%{$product_keyword}%");
//         }
//         if(!empty($company_keyword)) {
//             $query->where('company_id', '=', "$company_keyword");
//         }
//         return $query->get();
//     }

    public static function searchProducts($product_keyword, $company_keyword, $price_min, $price_max, $stock_min, $stock_max)
    {
        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.id', 'img_path', 'product_name', 'price', 'stock', 'company_name');

        if (!empty($product_keyword)) {
            $query->where('product_name', 'LIKE', "%{$product_keyword}%");
        }

        if (!empty($company_keyword)) {
            $query->where('company_id', '=', "$company_keyword");
        }

        if (!empty($price_min)) {
            $query->where('price', '>=', $price_min);
        }

        if (!empty($price_max)) {
            $query->where('price', '<=', $price_max);
        }

        if (!empty($stock_min)) {
            $query->where('stock', '>=', $stock_min);
        }

        if (!empty($stock_max)) {
            $query->where('stock', '<=', $stock_max);
        }

        return $query->get();
    }


    public static function getProductWithCompany($id)
    {
        return static::with('company:id,company_name')->find($id);
    }

    public static function getProductById($id)
    {
        return self::with('company:id,company_name')->find($id);
    }

    public static function createProduct($data)
    {
        if(request('img_path')){
            $original = request()->file('img_path')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $file = request()->file('img_path')->move('storage/images',$name);
        }
        Product::create([
            'company_id'=> $data['company_id'],
            'product_name'=> $data['product_name'],
            'price'=> $data['price'],
            'stock'=> $data['stock'],
            'comment'=> $data['comment'],
            'img_path' => $name
        ]);
    }

    public static function updateProduct($request) 
    {
        $product = Product::find($request['id']);
        $img_path = $request->img_path;
    
        if(!is_null($request['img_path'])){
            $original = request()->file('img_path')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $file = request()->file('img_path')->move('storage/images',$name);
            $product -> img_path = $name;
        }
        $product ->fill([
            'product_name' => $request['product_name'],
            'company_id' => $request['company_id'],
            'price' => $request['price'],
            'stock' => $request['stock'],
            'comment' => $request['comment'],
        ]);
        $product->save();
    }

    // public function sort($product_sort){
    //     $product_sort= Product::sortable()->get(); //sortable() を先に宣言
    // }


    /**
     * ソートされた商品情報を取得する
     *
     * @param  string  $sortColumn
     * @param  string  $sortDirection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSortedProducts($sortColumn, $sortDirection)
    {
        return $this->orderBy($sortColumn, $sortDirection)->get();
    }
}