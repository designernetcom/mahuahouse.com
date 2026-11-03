<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model {
    protected $fillable = ['title','description','badge_text','price','original_price','duration','inclusions','image_url','valid_until','is_featured','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean', 'is_featured' => 'boolean', 'valid_until' => 'date', 'inclusions' => 'array', 'price' => 'decimal:2', 'original_price' => 'decimal:2'];
}
