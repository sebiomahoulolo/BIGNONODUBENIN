<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Storage;

use Illuminate\Support\Str;

class CategoryController extends Controller
{
  public function index()
{
    $categories = Category::paginate(10); // Paginer les résultats
    // $categories = Category::all(); // Supprimez ou commentez cette ligne
    return view('admin.categories.index', compact('categories'));
}

public function create()
{
    $categories = Category::all(); // Récupère toutes les catégories
    return view('admin.categories.create', compact('categories'));
}



public function edit($id)
{
    $category = Category::findOrFail($id); // Récupère la catégorie ou retourne une erreur 404
    return view('admin.categories.edit', compact('category'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id',
        'order' => 'nullable|integer',
        'is_active' => 'boolean',
              'slug' => 'nullable|string|unique:categories,slug',
    
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        
    ]);

    // Création de la catégorie
    $category = new Category();
    $category->name = $request->name;
    $category->description = $request->description;
    $category->parent_id = $request->parent_id;
    $category->order = $request->order;
    $category->is_active = $request->is_active;
 $category->slug = Str::slug($request->name); // Génération automatique du slug
    
    // Gestion de l'image
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('categories', 'public');
        $category->image = $imagePath;
    }

    $category->save();

    return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès !');
}

    public function show(Category $category)
    {
        // Charger la catégorie avec le nombre de produits
        $category->loadCount('products');
        
        // Récupérer les produits associés à cette catégorie avec pagination
        $products = $category->products()
            ->orderBy('name')
            ->paginate(5);
            
        // Récupérer quelques autres catégories pour la sidebar
        $otherCategories = Category::where('id', '!=', $category->id)
            ->withCount('products')
            ->orderBy('name')
            ->limit(5)
            ->get();
            
        // Initialiser les statistiques à 0
        $totalViews = 0;
        $totalOrders = 0;
        $totalSales = 0;
        
        return view('admin.categories.show', compact(
            'category',
            'products',
            'otherCategories',
            'totalViews',
            'totalOrders',
            'totalSales'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Supprimer l'image associée
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        
        // Supprimer la catégorie
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }



}
