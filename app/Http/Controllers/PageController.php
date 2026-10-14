<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->take(8)
            ->get();
            
        return view('app', compact('featuredProducts'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function products()
    {
        $categories = Category::where('is_active', true)
            ->with(['products' => function($query) {
                $query->where('is_active', true)
                    ->with('category');
            }])
            ->orderBy('order')
            ->get();
        
        return view('pages.products', compact('categories'));
    }

    public function categories()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        return view('pages.categories', compact('categories'));
    }

    public function lits()
    {
        return view('pages.lits');
    }

    public function matelas()
    {
        return view('pages.matelas');
    }

    public function canapes()
    {
        return view('pages.canapes');
    }

    public function fauteuils()
    {
        return view('pages.fauteuils');
    }

    public function tables()
    {
        return view('pages.tables');
    }

    public function chaises()
    {
        return view('pages.chaises');
    }

    public function armoires()
    {
        return view('pages.armoires');
    }

    public function buffets()
    {
        return view('pages.buffets');
    }

    public function etageres()
    {
        return view('pages.etageres');
    }

    public function meublesTV()
    {
        return view('pages.meubles-tv');
    }

    public function commodes()
    {
        return view('pages.commodes');
    }

    public function chambres()
    {
        return view('pages.chambres');
    }

    public function salons()
    {
        return view('pages.salons');
    }

    public function sallesAManger()
    {
        return view('pages.salles-a-manger');
    }

    public function bureaux()
    {
        return view('pages.bureaux');
    }

    public function cuisines()
    {
        return view('pages.cuisines');
    }

    public function productDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        // Récupérer les produits similaires (même catégorie, exclure le produit actuel)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with('category')
            ->take(4)
            ->get();
        
        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }

    public function categoryShow($slug)
    {
        $category = \App\Models\Category::where('slug', $slug)
            ->orWhere('name', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with('category')
            ->paginate(12);
        
        return view('pages.category-show', compact('category', 'products'));
    }

    public function legalNotice()
    {
        return view('pages.legal-notice');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }
} 