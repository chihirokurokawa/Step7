<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //テーブル名　テーブルとモデルが紐ずく
    protected $table ='users';

    //可変項目
    protected $fillable =
    [
        'user_name',
        'email',
        'password',
        'email_verified_at'
    ];

    
}
