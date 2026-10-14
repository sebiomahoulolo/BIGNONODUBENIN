<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeDevis extends Model
{
    protected $table = 'demande_devis';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'indicatif',
        'material',
        'category_id',
        'category_name',
        'city',
        'delai_livraison',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
