<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model {
    protected $table = 'gallery_items';
    protected $fillable = ['title','image_url','category','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
