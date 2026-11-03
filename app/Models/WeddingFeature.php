<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingFeature extends Model
{
    protected $fillable = ['icon', 'title', 'description', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
