<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('App\Models\Sale');
    }
    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }
}
