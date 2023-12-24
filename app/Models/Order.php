<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'shipping_charge',
        'total_price',
        'order_amount',
        'payment_status',
        'current_status',
        'pay_now_qr',
        'customer_sms',
        'rider_sms',
        'invoice_id',
    ];

    protected $casts = [
        'shipping_charge' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // Relationships

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
