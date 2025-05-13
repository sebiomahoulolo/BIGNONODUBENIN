<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        return view('pages.products');
    }

    public function categories()
    {
        return view('pages.categories');
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
        return view('pages.product-detail', compact('product'));
    }
} 