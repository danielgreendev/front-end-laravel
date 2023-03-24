<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = [
        'payment_name', 'test_public_key','test_secret_key','live_public_key','live_secret_key','environment','status'
    ];
}
