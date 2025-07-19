<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','status','description'];
    public $timestamps = false;
    protected $attributes = ['status' => 1];
}
