<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
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

 public static function searchProducts($product_keyword, $company_keyword)
    {
        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.id', 'img_path', 'product_name', 'price', 'stock', 'company_name');

        if(!empty($product_keyword)) {
            $query->where('product_name', 'LIKE', "%{$product_keyword}%");
        }
        if(!empty($company_keyword)) {
            $query->where('company_id', '=', "$company_keyword");
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

}
