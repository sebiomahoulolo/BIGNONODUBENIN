<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'parent_id',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

public function children()
{
    return $this->hasMany(Category::class, 'parent_id');
}



   


} 