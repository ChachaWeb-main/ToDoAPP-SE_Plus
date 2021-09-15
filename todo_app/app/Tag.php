<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //Userとのリレーション
    public function user()
    {
        return $this->belongsTo('App\User'); // 1対多
    }
    
    public function todos()
    {
        return $this->belongsToMany('App\Todo'); //多対多
    }
}
