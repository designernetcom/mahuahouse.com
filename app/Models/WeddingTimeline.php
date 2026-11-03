<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingTimeline extends Model
{
    protected $fillable = ['title', 'description', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
