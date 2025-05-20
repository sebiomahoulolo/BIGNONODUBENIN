<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{

public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:newsletters,email',
    ]);

    Newsletter::create([
        'email' => $request->email,
    ]);

    return back()->with('success', 'Merci pour votre inscription à la newsletter !');
}


public function sendLatestProducts()
{
    $subscribers = Newsletter::all();
    $customers = Customer::all();
    $latestProducts = Product::latest()->take(4)->get();

    foreach ($subscribers as $subscriber) {
        Mail::send('emails.latest-products', [
            'products' => $latestProducts,
            'subscriber' => $subscriber
        ], function ($message) use ($subscriber) {
            $message->to($subscriber->email)
                    ->subject('🛍️ Nouveaux produits disponibles sur notre plateforme !');

        });
    }

     foreach ($customers as $customer) {
        Mail::send('emails.latest-products', [
            'products' => $latestProducts,
            'customer' => $customer
        ], function ($message) use ($customer) {
            $message->to($customer->email)
                    ->subject('🛍️ Nouveaux produits disponibles sur notre plateforme !');

        });
    }

    return back()->with('success', 'Les emails ont été envoyés avec succès à tous les abonnés.');
}

}
