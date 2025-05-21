<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filtres
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre_places', 'like', '%' . $request->search . '%')
                    ->orWhere('matiere', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'low':
                    $query->where('stock', '<', 10);
                    break;
                case 'out':
                    $query->where('stock', 0);
                    break;
                case 'in':
                    $query->where('stock', '>', 0);
                    break;
            }
        }

        if ($request->filled('price_range')) {
            list($min, $max) = explode('-', $request->price_range);
            $query->whereBetween('price', [$min, $max]);
        }

        // Tri
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        switch ($sort) {
            case 'name':
                $query->orderBy('nombre_places', $direction);
                break;
            case 'price':
                $query->orderBy('price', $direction);
                break;
            case 'stock':
                $query->orderBy('stock', $direction);
                break;
            default:
                $query->orderBy('created_at', $direction);
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.add-product', compact('categories'));
    }

   public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'nombre_places' => 'required|string|max:255',
            'matiere' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array|min:1|max:8',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        DB::beginTransaction();

        $product = new Product();
        $product->fill($validated);

        // Enregistrement des images dans public/products
        $images = [];
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('storages/products/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);

            // On stocke le chemin relatif à public (pas besoin de 'storage/')
            $images[] = 'products/' . $filename;
        }

        // Affecter le tableau directement (pas de json_encode)
        $product->images = $images;

        $product->save();

        DB::commit();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit créé avec succès !');
    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Erreur lors de la création du produit', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Une erreur est survenue lors de la création du produit : ' . $e->getMessage());
    }
}



    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'nombre_places' => 'required|string|max:255',
                'matiere' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0|lt:price',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'images' => 'nullable|array|max:8',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
                'is_featured' => 'boolean',
            ]);

            DB::beginTransaction();

            // Vérifier le nombre total d'images
            $currentImages = count($product->images);
            $newImages = $request->hasFile('images') ? count($request->file('images')) : 0;
            $totalImages = $currentImages + $newImages;

            if ($totalImages > 8) {
                throw new \Exception('Le nombre total d\'images ne peut pas dépasser 8.');
            }

            // Mise à jour des images
            if ($request->hasFile('images')) {
                // Supprimer les anciennes images
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }

                // Ajouter les nouvelles images
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $images[] = $path;
                }
                $product->images = $images;
            }

            $product->fill($validated);
            $product->save();

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produit mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour du produit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du produit : ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Supprimer les images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }

            $product->delete();

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produit supprimé avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression du produit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression du produit : ' . $e->getMessage());
        }
    }

    public function deleteImage(Product $product, Request $request)
    {
        try {
            $imageIndex = $request->input('image_index');

            if (!isset($product->images[$imageIndex])) {
                throw new \Exception('Image non trouvée.');
            }

            // Supprimer l'image du stockage
            Storage::disk('public')->delete($product->images[$imageIndex]);

            // Supprimer l'image du tableau
            $images = $product->images;
            unset($images[$imageIndex]);
            $images = array_values($images); // Réindexer le tableau

            $product->images = $images;
            $product->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'image', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
