<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Canapés',
                'description' => 'Une large gamme de canapés confortables et élégants pour votre salon',
                'is_active' => true,
                'order' => 1
            ],
            [
                'name' => 'Lits',
                'description' => 'Des lits de qualité pour un sommeil optimal',
                'is_active' => true,
                'order' => 2
            ],
            [
                'name' => 'Tables',
                'description' => 'Tables à manger, tables basses et tables de salon',
                'is_active' => true,
                'order' => 3
            ],
            [
                'name' => 'Chaises',
                'description' => 'Chaises de salle à manger et chaises de bureau',
                'is_active' => true,
                'order' => 4
            ],
            [
                'name' => 'Armoires',
                'description' => 'Armoires et dressings pour votre rangement',
                'is_active' => true,
                'order' => 5
            ],
            [
                'name' => 'Meubles TV',
                'description' => 'Meubles TV modernes et élégants',
                'is_active' => true,
                'order' => 6
            ],
            [
                'name' => 'Buffets',
                'description' => 'Buffets et vaisseliers pour votre salle à manger',
                'is_active' => true,
                'order' => 7
            ],
            [
                'name' => 'Bibliothèques',
                'description' => 'Bibliothèques et étagères pour vos livres et décorations',
                'is_active' => true,
                'order' => 8
            ],
            [
                'name' => 'Bureaux',
                'description' => 'Bureaux et meubles de bureau pour votre espace de travail',
                'is_active' => true,
                'order' => 9
            ],
            [
                'name' => 'Commodes',
                'description' => 'Commodes et meubles de rangement pour votre chambre',
                'is_active' => true,
                'order' => 10
            ],
            [
                'name' => 'Fauteuils',
                'description' => 'Fauteuils confortables pour votre salon',
                'is_active' => true,
                'order' => 11
            ],
            [
                'name' => 'Étagères',
                'description' => 'Étagères murales et de rangement',
                'is_active' => true,
                'order' => 12
            ],
            [
                'name' => 'Meubles de jardin',
                'description' => 'Meubles d\'extérieur pour votre jardin et terrasse',
                'is_active' => true,
                'order' => 13
            ],
            [
                'name' => 'Meubles d\'entrée',
                'description' => 'Meubles d\'entrée et de hall',
                'is_active' => true,
                'order' => 14
            ],
            [
                'name' => 'Meubles de salle de bain',
                'description' => 'Meubles et rangements pour votre salle de bain',
                'is_active' => true,
                'order' => 15
            ],
            [
                'name' => 'Tabourets',
                'description' => 'Tabourets et sièges d\'appoint',
                'is_active' => true,
                'order' => 16
            ],
            [
                'name' => 'Meubles modulables',
                'description' => 'Meubles modulables et personnalisables',
                'is_active' => true,
                'order' => 17
            ],
            [
                'name' => 'Rangements pour enfants',
                'description' => 'Meubles et rangements adaptés aux enfants',
                'is_active' => true,
                'order' => 18
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
                'order' => $category['order']
            ]);
        }
    }
} 