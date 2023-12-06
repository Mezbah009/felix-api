<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'product_id',
        'product_price',
        'quantity',
        'shipping_charge',
        'total_price',
        'payment_status',
        'current_status',
        'pay_now_qr',
        'customer_sms',
        'rider_sms',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // Relationships

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
