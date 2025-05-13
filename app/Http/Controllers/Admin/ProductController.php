<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filtres
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
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
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0|lt:price',
                'stock' => 'required|integer|min:0',
                'sku' => 'required|string|unique:products,sku',
                'category_id' => 'required|exists:categories,id',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
                'is_featured' => 'boolean',
            ]);

            $product = Product::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'],
                'price' => $validated['price'],
                'sale_price' => $validated['sale_price'] ?? null,
                'stock' => $validated['stock'],
                'sku' => $validated['sku'],
                'category_id' => $validated['category_id'],
                'is_active' => $request->boolean('is_active'),
                'is_featured' => $request->boolean('is_featured'),
            ]);

            // Gestion des images
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $images[] = $path;
                }
                $product->images = $images;
                $product->save();
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Le produit a été créé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du produit: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

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
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0|lt:price',
                'stock' => 'required|integer|min:0',
                'sku' => 'required|string|unique:products,sku,' . $product->id,
                'category_id' => 'required|exists:categories,id',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
                'is_featured' => 'boolean',
            ]);

            $product->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'],
                'price' => $validated['price'],
                'sale_price' => $validated['sale_price'] ?? null,
                'stock' => $validated['stock'],
                'sku' => $validated['sku'],
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
