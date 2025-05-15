<?php


// recuperer la liste des produits

use App\Models\Category;
use App\Models\Product;
use Illuminate\Cache\RateLimiting\Limit;

if (! function_exists('getProducts')) {
    function getProducts()
    {
        return Category::where('is_active', true)->get();
    }
}

if (! function_exists('getCategory')) {
    function getCategory()
    {
        return Category::where('is_active', true)->limit(6)->get();
    }
}
