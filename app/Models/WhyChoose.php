<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WhyChoose extends Model {
    public $timestamps = false;
    protected $table = 'why_choose';
    protected $fillable = ['title','description','icon','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
