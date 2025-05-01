<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = ['customer_id', 'reference_name', 'phone_number'];

    // Use the central database connection (usually 'mysql')
    protected $connection = 'mysql';
}

