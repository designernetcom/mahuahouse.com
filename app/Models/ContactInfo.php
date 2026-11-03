<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model {
    public $timestamps = false;
    protected $table = 'contact_infos';
    protected $fillable = ['key','label','value','icon','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
