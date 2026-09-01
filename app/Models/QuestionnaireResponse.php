<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireResponse extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'age',
        'fonction',
        'reponses',
    ];

    protected $casts = [
        'reponses' => 'array',
    ];
}