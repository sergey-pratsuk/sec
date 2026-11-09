<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckinPhoto extends Model
{
    protected $fillable = ['checkin_log_id', 'type', 'file_path'];

    public function log(): BelongsTo
    {
        return $this->belongsTo(CheckinLog::class, 'checkin_log_id');
    }
}
