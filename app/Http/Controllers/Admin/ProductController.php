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
            $query->where('nombre_places', 'like', '%' . $request->search . '%')
                  ->orWhere('matiere', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(10);
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
            Log::info('Début de la création du produit', ['request' => $request->all()]);

            $validated = $request->validate([
                'nombre_places' => 'required|string|max:255',
                'matiere' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0|lt:price',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'images' => 'required|array|min:2|max:8',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            Log::info('Données validées', ['validated' => $validated]);

            DB::beginTransaction();

            try {
                // Conversion des valeurs numériques
                $product = Product::create([
                    'nombre_places' => $validated['nombre_places'],
                    'matiere' => $validated['matiere'],
                    'description' => $validated['description'],
                    'price' => (float) $validated['price'],
                    'sale_price' => isset($validated['sale_price']) ? (float) $validated['sale_price'] : null,
                    'stock' => (int) $validated['stock'],
                    'category_id' => (int) $validated['category_id'],
                    'is_active' => true,
                    'is_featured' => false,
                ]);

                Log::info('Produit créé', ['product' => $product->toArray()]);

                // Gestion des images
                if ($request->hasFile('images')) {
                    $images = [];
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('products', 'public');
                        $images[] = $path;
                    }
                    $product->images = $images;
                    $product->save();
                    Log::info('Images enregistrées', ['images' => $images]);
                }

                DB::commit();
                Log::info('Transaction terminée avec succès');

                return redirect()
                    ->route('admin.products.index')
                    ->with('success', 'Le produit a été créé avec succès.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erreur lors de la création du produit dans la transaction', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

        } catch (\Exception $e) {
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

            // Vérifier le nombre total d'images
            $currentImages = count($product->images);
            $newImages = $request->hasFile('images') ? count($request->file('images')) : 0;
            $totalImages = $currentImages + $newImages;

            if ($totalImages > 8) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Le nombre total d\'images ne peut pas dépasser 8.');
            }

            if ($currentImages < 2 && $newImages === 0) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Le produit doit avoir au moins 2 images.');
            }

            $product->update([
                'nombre_places' => $validated['nombre_places'],
                'matiere' => $validated['matiere'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'sale_price' => $validated['sale_price'] ?? null,
                'stock' => $validated['stock'],
                'category_id' => $validated['category_id'],
                'is_active' => $request->boolean('is_active'),
                'is_featured' => $request->boolean('is_featured'),
            ]);

            // Gestion des nouvelles images
            if ($request->hasFile('images')) {
                $images = $product->images ?? [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $images[] = $path;
                }
                $product->images = $images;
                $product->save();
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Le produit a été mis à jour avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du produit: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du produit.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Supprimer les images
            if ($product->images) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $product->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Le produit a été supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du produit: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de la suppression du produit.');
        }
    }

    public function deleteImage(Request $request, Product $product)
    {
        try {
            $request->validate([
                'image' => 'required|string'
            ]);

            $image = $request->image;
            $images = $product->images;

            if (($key = array_search($image, $images)) !== false) {
                // Supprimer l'image du stockage
                Storage::disk('public')->delete($image);
                
                // Supprimer l'image du tableau
                unset($images[$key]);
                $images = array_values($images); // Réindexer le tableau
                
                // Mettre à jour le produit
                $product->images = $images;
                $product->save();

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'image: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue'], 500);
        }
    }
}
