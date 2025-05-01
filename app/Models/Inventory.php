<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'initial_quantity', 'ordered_quantity', 'stock_quantity', 'order_id'
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

