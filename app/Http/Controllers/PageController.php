<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
         ->where('stock', '>', 0)
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



    public function categories()
    {
        $categories = \App\Models\Category::with(['products' => function($query) {
            $query->where('is_active', true)
                  ->take(3); // Limite à 3 produits par catégorie
        }])
        ->where('is_active', true)
        ->get();

        return view('pages.categories', compact('categories'));
    }

    public function categoryShow($slug)
    {

        $category = \App\Models\Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();


        $products = $category->products()
            ->where('is_active', true)
            ->paginate(12);

        return view('pages.category-show', compact('category', 'products'));
    }

    public function showPage($page)
{
    $view = 'pages.' . $page;

    if (view()->exists($view)) {
        return view($view);
    }

    abort(404);
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
    // Récupérer le produit
    $product = \App\Models\Product::findOrFail($id);

    // Vérifier que la catégorie existe
    if (!$product->category) {
        return abort(404, "Catégorie du produit introuvable !");
    }

    // Trouver les produits similaires de la même catégorie
    $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id) // Exclure le produit en cours
        ->where('is_active', true)
        ->limit(4) // Limite à 4 produits similaires
        ->get();

    return view('pages.product-detail', compact('product', 'relatedProducts'));
}
public function products()
{
    // Récupérer toutes les catégories actives
    $categories = \App\Models\Category::where('is_active', true)->get();

    // Récupérer les produits actifs avec pagination
    $products = \App\Models\Product::where('is_active', true)->paginate(12);

    return view('pages.products', compact('categories', 'products'));
}

}
