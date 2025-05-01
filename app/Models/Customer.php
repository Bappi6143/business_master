<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address'];

    public function getConnectionName()
    {
        return auth()->check() && auth()->user()->tenant ? 'tenant' : $this->connection;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_contact', 'phone');
    }
}
