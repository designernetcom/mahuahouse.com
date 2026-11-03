<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model {
    protected $fillable = ['title','subtitle','description','image_url','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
