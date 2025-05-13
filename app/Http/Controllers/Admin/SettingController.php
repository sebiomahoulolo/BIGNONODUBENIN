<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }

    public function seed()
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Bignon du Benin',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Nom du site',
                'description' => 'Le nom de votre site web'
            ],
            [
                'key' => 'site_description',
                'value' => 'Votre spécialiste en meubles de qualité',
                'group' => 'general',
                'type' => 'textarea',
                'label' => 'Description du site',
                'description' => 'Une brève description de votre site'
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@bignonbenin.com',
                'group' => 'contact',
                'type' => 'email',
                'label' => 'Email de contact',
                'description' => 'L\'adresse email de contact principale'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+229 123 456 789',
                'group' => 'contact',
                'type' => 'text',
                'label' => 'Téléphone de contact',
                'description' => 'Le numéro de téléphone de contact'
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/bignonbenin',
                'group' => 'social',
                'type' => 'text',
                'label' => 'Facebook',
                'description' => 'L\'URL de votre page Facebook'
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/bignonbenin',
                'group' => 'social',
                'type' => 'text',
                'label' => 'Instagram',
                'description' => 'L\'URL de votre compte Instagram'
            ],
            [
                'key' => 'shipping_cost',
                'value' => '5000',
                'group' => 'shipping',
                'type' => 'number',
                'label' => 'Frais de livraison',
                'description' => 'Les frais de livraison standard en FCFA'
            ],
            [
                'key' => 'free_shipping_threshold',
                'value' => '100000',
                'group' => 'shipping',
                'type' => 'number',
                'label' => 'Seuil de livraison gratuite',
                'description' => 'Montant minimum pour la livraison gratuite en FCFA'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres par défaut créés avec succès.');
    }
} 