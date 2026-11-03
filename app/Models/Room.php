<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Room extends Model {
    protected $fillable = ['name','room_type','description','price_per_night','max_guests','amenities','image_url','badge_text','badge_color','is_featured','is_active','sort_order'];
    protected $casts = ['amenities' => 'array', 'is_featured' => 'boolean', 'is_active' => 'boolean'];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
