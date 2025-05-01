<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;
use App\Models\DeliveryCharge;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_contact', 'customer_name', 'customer_address', 
        'products', 'order_status', 'delivery_zone_id', 'zone_name',
        'delivery_charge', 'subtotal', 'discount_amount',
        'total_price', 'ordered_quantity'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryZone()
    {
        return $this->belongsTo(DeliveryCharge::class, 'delivery_zone_id');
    }
    public function products()
{
    return $this->hasMany(Product::class);
}
}