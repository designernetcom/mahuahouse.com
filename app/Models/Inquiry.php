<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model {
    protected $fillable = ['type','name','email','phone','subject','message','check_in','check_out','guests','room_type','status'];
}
