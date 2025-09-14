<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchseOrderItem;
use App\Traits\DataTableCommonTrait;
use Illuminate\Database\Eloquent\Model;

class PurchseOrder extends Model
{
    use DataTableCommonTrait;
    protected $fillable = ['order_number', 'order_date', 'supplier_id','total_amount', 'paid_amount', 'due_amount', 'status', 'notes'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_order_product', 'purchase_order_id', 'product_id')
            ->withPivot('quantity', 'unit_price', 'total_price')
            ->withTimestamps();
    }
    
    public function purchseOrderItem()
    {
        return $this->hasMany(PurchseOrderItem::class, 'purchse_order_id', 'id');
    }
    
}
