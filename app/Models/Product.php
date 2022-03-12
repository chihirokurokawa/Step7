<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Company;

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
    public function sale()
    {
        return $this->hasOne('App\Sale');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    
}
