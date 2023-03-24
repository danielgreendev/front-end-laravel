<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemAddons extends Model
{
    protected $table='systemaddons';
    protected $fillable=['name','unique_identifier','version','activated','image'];
}
