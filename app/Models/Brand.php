<?php

namespace App\Models;

use App\Traits\DataTableCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use DataTableCommonTrait;
    protected $fillable = ['name', 'logo'];
}
