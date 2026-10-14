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

if (! function_exists('getCategory')) {
    function getCategory()
    {
        // Retourne les catégories actives, triées par ordre
        return Category::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();
    }
}

if (! function_exists('base_color_header')) {
    function base_color_header()
    {
        // Retourne un style CSS avec un overlay semi-transparent
        // Utilise la couleur primaire du site avec une opacité
        return 'background: rgba(44, 62, 80, 0.7); backdrop-filter: blur(5px);';
    }
}

if (! function_exists('base_color')) {
    function base_color()
    {
        // Retourne un style CSS avec la couleur primaire du site
        // Utilise la couleur primaire #2c3e50 (44, 62, 80 en RGB)
        return 'background-color: #2c3e50; color: white;';
    }
}

if (! function_exists('border_color')) {
    function border_color()
    {
        // Retourne un style CSS pour la couleur de bordure (boutons outline)
        // Utilise la couleur primaire #2c3e50
        return 'border-color: #2c3e50;';
    }
}

if (! function_exists('text_color_1')) {
    function text_color_1()
    {
        // Retourne un style CSS pour la couleur du texte primaire
        // Utilise la couleur primaire #2c3e50
        return 'color: #2c3e50;';
    }
}
