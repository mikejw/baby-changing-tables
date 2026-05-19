<?php

namespace App\Models;

use Database\Factories\FeedFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;

class Feed extends Model
{
    /** @use HasFactory<FeedFactory> */
    use HasFactory;

    protected $fillable = [
        'nappy_wet',
        'nappy_poo',
        'breast_fed',
        'changed_by',
        'clothes_changed_by',
        'created_by',
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
            $hasNappy = $feed->nappy_wet || $feed->nappy_poo;
            $hasFormula = $feed->formula_ounces !== null && (float) $feed->formula_ounces > 0;
            $hasSkinMinutes = $feed->skin_to_skin_minutes !== null && (int) $feed->skin_to_skin_minutes > 0;
            $hasSunMinutes = $feed->time_in_sun !== null && (int) $feed->time_in_sun > 0;

            Validator::make(
                [
                    'cry_level' => $feed->cry_level,
                    'changed_by' => $feed->changed_by,
                    'clothes_changed_by' => $feed->clothes_changed_by,
                    'fed_by' => $feed->fed_by,
                    'skin_to_skin_with' => $feed->skin_to_skin_with,
                    'time_in_sun_with' => $feed->time_in_sun_with,
                    'change_of_clothes' => $feed->change_of_clothes,
                    'skin_to_skin_minutes' => $feed->skin_to_skin_minutes,
                    'time_in_sun' => $feed->time_in_sun,
                    'formula_ounces' => $feed->formula_ounces,
                ],
                [
                    'cry_level' => ['required', 'integer', 'between:0,10'],
                    'changed_by' => ['nullable', 'integer', 'exists:users,id'],
                    'clothes_changed_by' => ['nullable', 'integer', 'exists:users,id'],
                    'fed_by' => ['nullable', 'integer', 'exists:users,id'],
                    'skin_to_skin_with' => ['nullable', 'integer', 'exists:users,id'],
                    'time_in_sun_with' => ['nullable', 'integer', 'exists:users,id'],
                    'change_of_clothes' => ['boolean'],
                    'skin_to_skin_minutes' => ['nullable', 'integer', 'min:0', 'max:600'],
                    'time_in_sun' => ['nullable', 'integer', 'min:0', 'max:99'],
                    'formula_ounces' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
                ],
                [
                    'cry_level.between' => 'The cry level must be between 0 (no crying) and 10 (maximum crying).',
                ],
            )->after(function (\Illuminate\Validation\Validator $validator) use ($feed, $hasNappy, $hasFormula, $hasSkinMinutes, $hasSunMinutes): void {
                if ($hasNappy && $feed->changed_by === null) {
                    $validator->errors()->add(
                        'changed_by',
                        'Select who changed the nappy when it was wet or pooey.',
                    );
                }

                if (! $hasNappy && $feed->changed_by !== null) {
                    $validator->errors()->add(
                        'changed_by',
                        'Remove who changed the nappy unless it was wet or pooey.',
                    );
                }

                if ($hasFormula && $feed->fed_by === null) {
                    $validator->errors()->add(
                        'fed_by',
                        'Select who fed when formula amount is recorded.',
                    );
                }

                if (! $hasFormula && $feed->fed_by !== null) {
                    $validator->errors()->add(
                        'fed_by',
                        'Remove who fed unless a formula amount is recorded.',
                    );
                }

                if ($feed->change_of_clothes && $feed->clothes_changed_by === null) {
                    $validator->errors()->add(
                        'clothes_changed_by',
                        'Select who changed the clothes when there was a change of clothes.',
                    );
                }

                if (! $feed->change_of_clothes && $feed->clothes_changed_by !== null) {
                    $validator->errors()->add(
                        'clothes_changed_by',
                        'Remove who changed the clothes unless there was a change of clothes.',
                    );
                }

                if ($hasSkinMinutes && $feed->skin_to_skin_with === null) {
                    $validator->errors()->add(
                        'skin_to_skin_with',
                        'Select who held for skin-to-skin when minutes are recorded.',
                    );
                }

                if (! $hasSkinMinutes && $feed->skin_to_skin_with !== null) {
                    $validator->errors()->add(
                        'skin_to_skin_minutes',
                        'Enter skin-to-skin minutes when someone is selected, or clear who held.',
                    );
                }

                if ($hasSunMinutes && $feed->time_in_sun_with === null) {
                    $validator->errors()->add(
                        'time_in_sun_with',
                        'Select who was present for time in sun when minutes are recorded.',
                    );
                }

                if (! $hasSunMinutes && $feed->time_in_sun_with !== null) {
                    $validator->errors()->add(
                        'time_in_sun',
                        'Enter time in sun minutes when someone is selected, or clear who was present.',
                    );
                }
            })->validate();

            if ($feed->skin_to_skin_minutes !== null && (int) $feed->skin_to_skin_minutes <= 0) {
                $feed->skin_to_skin_minutes = null;
            }

            if ($feed->time_in_sun !== null && (int) $feed->time_in_sun <= 0) {
                $feed->time_in_sun = null;
            }

            if ($feed->formula_ounces !== null && (float) $feed->formula_ounces <= 0) {
                $feed->formula_ounces = null;
            }
        });
    }

    public function isFeeding(): bool
    {
        return $this->breast_fed
            || ($this->formula_ounces !== null && (float) $this->formula_ounces > 0);
    }

    /**
     * @param  Builder<Feed>  $query
     * @return Builder<Feed>
     */
    public function scopeFeedings(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query->where('breast_fed', true)
                ->orWhere('formula_ounces', '>', 0);
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

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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
