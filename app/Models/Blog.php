<?php

namespace App\Models;

use App\Models\User;
use App\Traits\DataTableCommonTrait;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use DataTableCommonTrait;
    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'image',
        'description',
        'meta_title',
        'meta_description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
