<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchseOrderItem extends Model
{
    protected $fillable = ['purchse_order_id', 'product_id', 'quantity', 'unit_price', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchseOrder::class, 'purchse_order_id', 'id');
    }
    

}
