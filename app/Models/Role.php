<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','status','description'];
    public $timestamps = false;
    protected $attributes = ['status' => 1];
    public function getDescriptionAttribute(?string $value): string
    {
        // If the value is null, return an empty string; otherwise, return the value as is.
        return $value ?? '';
    }
}
