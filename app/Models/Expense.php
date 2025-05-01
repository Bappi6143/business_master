<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['expense_category_id', 'date', 'amount', 'details'];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    // Check tenant connection
    public function getConnectionName()
    {
        return auth()->check() && auth()->user()->tenant ? 'tenant' : $this->connection;
    }
}
