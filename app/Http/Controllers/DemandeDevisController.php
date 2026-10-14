<?php

namespace App\Http\Controllers;

use App\Models\DemandeDevis;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemandeDevisController extends Controller
{
    public function index()
    {
        $demande_devis = DemandeDevis::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.demande-devis.index', compact('demande_devis'));
    }

    public function storeDemandeDevis(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'indicatif' => 'nullable|string|max:10',
                'material' => 'nullable|string|max:255',
                'category_id' => 'nullable|exists:categories,id',
                'city' => 'nullable|string|max:255',
                'delai_livraison' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Récupérer le nom de la catégorie si category_id est fourni
            $categoryName = null;
            if (!empty($validated['category_id'])) {
                $category = Category::find($validated['category_id']);
                $categoryName = $category ? $category->name : null;
            }

            DemandeDevis::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => ($validated['indicatif'] ?? '') . ($validated['phone'] ?? ''),
                'indicatif' => $validated['indicatif'] ?? null,
                'material' => $validated['material'] ?? null,
                'category_id' => $validated['category_id'] ?? null,
                'category_name' => $categoryName,
                'city' => $validated['city'] ?? null,
                'delai_livraison' => $validated['delai_livraison'] ?? null,
                'description' => $validated['description'] ?? null,
            ]);

            return redirect()->back()
                ->with('success', 'Votre demande de devis a été envoyée avec succès ! Nous vous contacterons bientôt.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'envoi de votre demande. Veuillez réessayer.');
        }
    }
}
