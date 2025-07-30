<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['user_id', 'name', 'phone', 'dob', 'photo', 'gender'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    public $incrementing = false;
}
