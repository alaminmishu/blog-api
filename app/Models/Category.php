<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];

    // Parent category (for nested categories)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    // Child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Posts in this category
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
