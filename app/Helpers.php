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

if (!function_exists('base_color')) {
    function base_color()
    {
        return "background-color :  #366ba2";
    }
}



if (!function_exists('text_color_1')) {
    function text_color_1()
    {
        return "color :  #366ba2";
    }
}

if (!function_exists('border_color')) {
    function border_color()
    {
        return "border : 1px solid  #366ba2";
    }
}

if (!function_exists('second_color')) {
    function second_color()
    {
        return "color :  #ff2c2c";
    }
}

if (!function_exists('text_color_2')) {
    function text_color_2()
    {
        return "color :  #222222";
    }
}

if (!function_exists('base_color_header')) {
    function base_color_header()
    {
       return "background-color: rgba(54, 107, 162, 0.5)";

    }
}

// style="{{ background_color_1() }}"
