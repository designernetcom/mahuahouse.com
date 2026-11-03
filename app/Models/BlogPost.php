<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model {
    protected $table = 'blog_posts';
    protected $fillable = ['title','slug','excerpt','content','image_url','author','category','tags','is_published','is_featured','read_time','published_at'];
    protected $casts = ['tags' => 'array', 'is_published' => 'boolean', 'is_featured' => 'boolean', 'published_at' => 'datetime'];
}
