<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use \Rutorika\Sortable\SortableTrait;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function goal()
    {
        return $this->belongsTo('App\Goal');
    }
}
