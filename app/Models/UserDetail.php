<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'account_number', 'bank_id', 'phone',
    ];

    protected $hidden = [

    ];
}
