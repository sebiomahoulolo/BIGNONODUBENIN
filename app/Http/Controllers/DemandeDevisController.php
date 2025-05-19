<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandeDevisRequest;
use App\Models\DemandeDevis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Category;


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
        // 1. Validation des données
        $validated = $request->validated();

        // 2. Enregistrement en base de données
        $demande = new DemandeDevis();
        $demande->name = $validated['name'];
        $demande->email = $validated['email'];
        $demande->material = $validated['material'];
        $demande->category_id = $validated['category_id'];
        $demande->phone = $validated['indicatif'] . $validated['phone'];
        $demande->ville = $validated['city'];
        $demande->delai_livraison = $validated['delai_livraison'];
        $demande->description = $validated['description'];
        $demande->save();

        // 3. Envoi de l'e-mail
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bignondubenin1@gmail.com';
            $mail->Password = 'adsl xchc jjhq sijo';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

         
          $mail->setFrom('bignondubenin1@gmail.com', 'Bignon du Benin');
            $mail->addAddress('bignondubenin1@gmail.com');
$category = Category::find($validated['category_id']);
$nomCategorie = $category ? $category->name : 'Catégorie inconnue';

            $mail->Subject = 'Nouvelle demande de devis';
            $mail->Body =
                "Nom: {$validated['name']}\n" .
                "Email: {$validated['email']}\n" .
                "Matériel: {$validated['material']}\n" .
                "Produit: {$nomCategorie}\n" .
                "Téléphone: {$validated['indicatif']} {$validated['phone']}\n" .
                "Ville: {$validated['city']}\n" .
                "Délai de livraison: {$validated['delai_livraison']} jours\n" .
                "Description: {$validated['description']}";

            $mail->send();

            return back()->with('success', 'Demande de devis enregistrée et envoyée avec succès.');
        } catch (Exception $e) {
            Log::error("Erreur lors de l’envoi de l’e-mail : " . $mail->ErrorInfo);
            return back()->with('success', 'Demande enregistrée, mais l’envoi de l’e-mail a échoué.');
        }

    } catch (\Exception $e) {
        Log::error('Erreur lors de l’enregistrement de la demande de devis : ' . $e->getMessage());
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Une erreur est survenue lors de l’enregistrement.');
    }
}

}
