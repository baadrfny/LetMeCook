<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the recipes for this category.
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'category_id');
    }
}
