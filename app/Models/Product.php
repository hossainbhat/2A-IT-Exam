<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Category;
use App\Traits\DataTableCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use DataTableCommonTrait;
    protected $fillable = ['name', 'category_id', 'brand_id', 'unit_id', 'product_code', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
