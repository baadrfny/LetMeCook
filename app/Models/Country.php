<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'country_id');
    }
}
