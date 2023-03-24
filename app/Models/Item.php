<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';

    public function variation(){
        return $this->hasMany('App\Models\Variants','item_id','id')->select('variants.id','variants.item_id','variants.name','variants.price');
    }

    public function extras(){
        return $this->hasMany('App\Models\Extra','item_id','id')->select('id','name','price','item_id');
    }
}
