<?php

namespace App\Models;

use App\Traits\DataTableCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use DataTableCommonTrait;
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'status',
    ];
}
