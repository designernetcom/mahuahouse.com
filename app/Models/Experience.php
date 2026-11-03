<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model {
    public $timestamps = false;
    protected $table = 'experiences';
    protected $fillable = ['title','description','icon','image_url','category','link','is_featured','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean', 'is_featured' => 'boolean'];
}
