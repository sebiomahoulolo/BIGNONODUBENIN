<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            Newsletter::firstOrCreate(
                ['email' => $validated['email']],
                ['is_active' => true]
            );

            return redirect()->back()
                ->with('success', 'Vous avez été inscrit à notre newsletter avec succès !');
        } catch (\Exception $e) {
            Log::error('Newsletter subscription error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');
        }
    }

    public function sendLatestProducts()
    {
        try {
            // Récupérer les 10 derniers produits actifs
            $products = Product::where('is_active', true)
                ->with('category')
                ->latest()
                ->take(10)
                ->get();

            if ($products->isEmpty()) {
                return redirect()->back()
                    ->with('error', 'Aucun produit disponible à envoyer.');
            }

            // Récupérer tous les abonnés actifs
            $subscribers = Newsletter::where('is_active', true)->get();

            if ($subscribers->isEmpty()) {
                return redirect()->back()
                    ->with('error', 'Aucun abonné à la newsletter.');
            }

            $sentCount = 0;
            $errors = [];

            foreach ($subscribers as $subscriber) {
                try {
                    Mail::send('emails.latest-products', [
                        'products' => $products
                    ], function ($message) use ($subscriber) {
                        $message->to($subscriber->email)
                            ->subject('Nouveaux produits disponibles - ' . config('app.name'));
                    });
                    $sentCount++;
                } catch (\Exception $e) {
                    $errors[] = $subscriber->email . ': ' . $e->getMessage();
                    Log::error('Newsletter send error for ' . $subscriber->email . ': ' . $e->getMessage());
                }
            }

            if ($sentCount > 0) {
                $message = "Newsletter envoyée avec succès à {$sentCount} abonné(s).";
                if (!empty($errors)) {
                    $message .= " Erreurs: " . count($errors) . " email(s) non envoyé(s).";
                }
                return redirect()->back()->with('success', $message);
            } else {
                return redirect()->back()
                    ->with('error', 'Aucun email n\'a pu être envoyé. Vérifiez la configuration email.');
            }

        } catch (\Exception $e) {
            Log::error('Newsletter send error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }
}
