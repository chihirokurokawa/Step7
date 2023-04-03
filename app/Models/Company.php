<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    //テーブル名　テーブルとモデルが紐ずく
    protected $table ='companies';

    //可変項目
    protected $fillable =
    [
        'company_name',
        'street_address',
        'representative_name'
    ];
    
    public function getProducts()
    {
        return $this->hasMany('App\Models\Product');
    }

    public static function getCompanies()
    {
        $companies = Company::select('id', 'company_name')->get();
        return $companies;
    }

}
