<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
  public function index(Request $request)
{
    $query = Category::withCount('products');

    // Filtres
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('status')) {
        $query->where('is_active', $request->status === 'active');
    }

    if ($request->filled('parent')) {
        if ($request->parent === 'none') {
            $query->whereNull('parent_id');
        } else {
            $query->where('parent_id', $request->parent);
        }
    }

    // Tri
    $sort = $request->get('sort', 'name');
    $direction = $request->get('direction', 'asc');
    
    switch ($sort) {
        case 'products':
            $query->orderBy('products_count', $direction);
            break;
        case 'created':
            $query->orderBy('created_at', $direction);
            break;
        default:
            $query->orderBy('name', $direction);
    }

    $categories = $query->paginate(10)->withQueryString();
    $parentCategories = Category::whereNull('parent_id')->get();

    return view('admin.categories.index', compact('categories', 'parentCategories'));
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
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        DB::beginTransaction();

        // Générer le slug
        $validated['slug'] = Str::slug($validated['name']);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $imagePath;
        }

        $category = Category::create($validated);

        DB::commit();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès !');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erreur lors de la création de la catégorie', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Une erreur est survenue lors de la création de la catégorie : ' . $e->getMessage());
    }
}

    public function show(Category $category)
    {
        $category->loadCount('products');
        
        // Charger les produits avec pagination
        $products = $category->products()
            ->withCount('orderItems')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_products' => $category->products_count,
            'total_sales' => $category->products->sum(function($product) {
                return $product->orderItems->sum('total');
            }),
            'total_orders' => $category->products->sum(function($product) {
                return $product->orderItems->count();
            }),
            'average_price' => $category->products->avg('price')
        ];

        $otherCategories = Category::where('id', '!=', $category->id)
            ->withCount('products')
            ->orderBy('name')
            ->limit(5)
            ->get();

        return view('admin.categories.show', compact('category', 'products', 'stats', 'otherCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string',
                'parent_id' => [
                    'nullable',
                    'exists:categories,id',
                    function ($attribute, $value, $fail) use ($category) {
                        if ($value == $category->id) {
                            $fail('Une catégorie ne peut pas être sa propre sous-catégorie.');
                        }
                    }
                ],
                'order' => 'nullable|integer',
                'is_active' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            DB::beginTransaction();

            // Générer le slug
            $validated['slug'] = Str::slug($validated['name']);

            // Gestion de l'image
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $imagePath = $request->file('image')->store('categories', 'public');
                $validated['image'] = $imagePath;
            }

            $category->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Catégorie mise à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de la catégorie', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de la catégorie : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();

            // Vérifier s'il y a des produits associés
            if ($category->products()->count() > 0) {
                throw new \Exception('Impossible de supprimer cette catégorie car elle contient des produits.');
            }

            // Vérifier s'il y a des sous-catégories
            if ($category->children()->count() > 0) {
                throw new \Exception('Impossible de supprimer cette catégorie car elle contient des sous-catégories.');
            }

            // Supprimer l'image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            DB::commit();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Catégorie supprimée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression de la catégorie', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression de la catégorie : ' . $e->getMessage());
        }
    }



}
