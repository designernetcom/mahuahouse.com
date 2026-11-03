<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model {
    protected $fillable = ['name','location','photo_url','review','rating','visit_date','is_active','sort_order'];
    protected $casts = ['is_active' => 'boolean', 'visit_date' => 'date'];
}
