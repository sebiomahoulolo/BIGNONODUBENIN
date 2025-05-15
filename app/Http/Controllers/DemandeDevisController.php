<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandeDevisRequest;
use App\Models\DemandeDevis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DemandeDevisController extends Controller
{
    // Recuperation de demande de devis enregistré
    public function index()
    {
        $demande_devis = DemandeDevis::join('categories', 'demande_devis.category_id', '=', 'categories.id')
            ->orderBy('demande_devis.id', 'desc')
            ->select('demande_devis.*', 'categories.name as category_name')
            ->paginate(10);

        return view('admin.demande-devis.index', compact('demande_devis'));
    }


    public function storeDemandeDevis(DemandeDevisRequest $request)
    {
        try {
            $validated = $request->validated();

            $demande = new DemandeDevis();
            $demande->name = $validated['name'];
            $demande->email = $validated['email'];
            $demande->material = $validated['material'];
            $demande->category_id = $validated['category_id'];
            $demande->phone = $validated['indicatif'] . '' . $validated['phone'];
            $demande->ville = $validated['city'];
            $demande->delai_livraison = $validated['delai_livraison'];
            $demande->description = $validated['description'];

            $demande->save();

            return redirect()->back()->with('success', 'Demande de devis enregistrée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l’enregistrement de la demande de devis : ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l’enregistrement.');
        }
    }
}
