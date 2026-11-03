<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model {
    public $timestamps = false;
    protected $table = 'team_members';
    protected $fillable = ['name','role','bio','image_url','social_facebook','social_instagram','social_twitter','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
