<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'reg_number',
        'brand',
        'model',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function photos()
    {
        return $this->hasMany(CarPhoto::class);
    }
}
