<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'action', 'qty', 'stock_date', 'purchase_rate', 'purchase_no', 'sales_invoice_no', 'remarks', 'supplier_name', 'chalan_no'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function updateProductQuantity()
    {
        $product = $this->product;

        if ($this->action === 'increase') {
            $product->qty += $this->qty;
        } elseif ($this->action === 'decrease') {
            $product->qty -= $this->qty;
        }

        $product->save();
    }
}
