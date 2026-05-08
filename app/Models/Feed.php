<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /** @use HasFactory<\Database\Factories\FeedFactory> */
    use HasFactory;

    protected $fillable = [
        'nappy_wet',
        'nappy_poo',
        'breast_fed',
        'changed_by',
        'fed_by',
        'skin_to_skin_with',
        'skin_to_skin_minutes',
        'notes',
        'formula_ounces',
        'cry_level',
        'temperature',
        'change_of_clothes',
        'table_wee',
        'table_poo',
        'time_in_sun',
    ];

    protected $casts = [
        'nappy_wet' => 'boolean',
        'nappy_poo' => 'boolean',
        'breast_fed' => 'boolean',
        'change_of_clothes' => 'boolean',
        'table_wee' => 'boolean',
        'table_poo' => 'boolean',
        'formula_ounces' => 'decimal:2',
        'temperature' => 'decimal:2',
    ];
}
