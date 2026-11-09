<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheckinLog extends Model
{
    protected $fillable = ['license_plate', 'material_id', 'volume', 'user_id', 'checked_in_at'];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    // фото движения
    public function photos(): HasMany
    {
        return $this->hasMany(CheckinPhoto::class);
    }

    // охранник
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
