<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $methods = [
            [
                'name' => 'Paiement à la livraison',
                'code' => 'cash_on_delivery',
                'description' => 'Paiement en espèces lors de la livraison',
                'is_active' => true
            ],
            [
                'name' => 'Virement bancaire',
                'code' => 'bank_transfer',
                'description' => 'Paiement par virement bancaire',
                'is_active' => true
            ],
            [
                'name' => 'Carte de crédit',
                'code' => 'credit_card',
                'description' => 'Paiement par carte de crédit',
                'is_active' => true
            ],
            [
                'name' => 'Mobile Money',
                'code' => 'mobile_money',
                'description' => 'Paiement par Mobile Money',
                'is_active' => true
            ]
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
} 