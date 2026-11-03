<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model {
    public $timestamps = false;
    protected $fillable = ['value','label','icon','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
