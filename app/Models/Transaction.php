<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';

    public function users(){
        return $this->hasOne('App\Models\User','id','restaurant')->select('id','name','email','mobile');
    }

}
