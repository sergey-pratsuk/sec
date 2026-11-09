<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = ['name', 'unit'];

    public function logs(): HasMany
    {
        return $this->hasMany(CheckinLog::class);
    }
}
