<?php


// recuperer la liste des produits

use App\Models\Category;
use App\Models\Product;

if (! function_exists('getProducts')) {
    function getProducts()
    {
        return Category::all();
    }
}
