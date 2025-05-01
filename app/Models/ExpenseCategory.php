<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = ['name', 'status'];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id');
    }

    // Return tenant connection for tenant users, else use default
    public function getConnectionName()
    {
        if (auth()->check() && auth()->user()->tenant) {
            return 'tenant';  // tenant database connection
        }

        return parent::getConnectionName();  // default connection for admin (main db)
    }
}
