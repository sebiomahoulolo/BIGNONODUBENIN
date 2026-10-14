<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $toEmail = env('MAIL_TO_ADDRESS', config('mail.from.address'));
            
            Mail::send('emails.contact', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'subject' => $validated['subject'],
                'messageContent' => $validated['message'],
            ], function ($message) use ($validated, $toEmail) {
                $message->to($toEmail)
                    ->subject('Nouveau message de contact : ' . $validated['subject'])
                    ->replyTo($validated['email'], $validated['name']);
            });

            return redirect()->route('pages.contact')
                ->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');

        } catch (\Exception $e) {
            // Logger l'erreur pour le débogage
            Log::error('Mail send error: ' . $e->getMessage());
            Log::error('Mail send error trace: ' . $e->getTraceAsString());
            
            // En mode développement, afficher l'erreur détaillée
            $errorMessage = config('app.debug') 
                ? 'Erreur: ' . $e->getMessage() 
                : 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer plus tard.';
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }
}
