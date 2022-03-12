<?php

namespace App\Models;
namespace App;

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
    

}
