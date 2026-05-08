<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;

class Feed extends Model
{
    /** @use HasFactory<\Database\Factories\FeedFactory> */
    use HasFactory;

    protected $fillable = [
        'nappy_wet',
        'nappy_poo',
        'breast_fed',
        'changed_by',
        'clothes_changed_by',
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
        'time_in_sun_with',
    ];

    protected $casts = [
        'nappy_wet' => 'boolean',
        'nappy_poo' => 'boolean',
        'breast_fed' => 'boolean',
        'change_of_clothes' => 'boolean',
        'table_wee' => 'boolean',
        'table_poo' => 'boolean',
        'cry_level' => 'integer',
        'skin_to_skin_minutes' => 'integer',
        'time_in_sun' => 'integer',
        'formula_ounces' => 'decimal:2',
        'temperature' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $feed): void {
            Validator::make(
                ['cry_level' => $feed->cry_level],
                ['cry_level' => ['nullable', 'integer', 'between:0,10']],
                ['cry_level.between' => 'The cry level must be between 0 (no crying) and 10 (maximum crying).'],
            )->validate();

            if ((int) $feed->skin_to_skin_minutes <= 0) {
                $feed->skin_to_skin_minutes = null;
                $feed->skin_to_skin_with = null;
            }

            if ((int) $feed->time_in_sun <= 0) {
                $feed->time_in_sun = null;
                $feed->time_in_sun_with = null;
            }

            if ($feed->formula_ounces === null || (float) $feed->formula_ounces <= 0) {
                $feed->formula_ounces = null;
                $feed->fed_by = null;
            }

            if (! $feed->nappy_wet && ! $feed->nappy_poo) {
                $feed->changed_by = null;
            }

            if (! $feed->change_of_clothes) {
                $feed->clothes_changed_by = null;
            }
        });
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function clothesChangedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'clothes_changed_by');
    }

    public function fedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fed_by');
    }

    public function skinToSkinWith(): BelongsTo
    {
        return $this->belongsTo(User::class, 'skin_to_skin_with');
    }

    public function timeInSunWith(): BelongsTo
    {
        return $this->belongsTo(User::class, 'time_in_sun_with');
    }
}
