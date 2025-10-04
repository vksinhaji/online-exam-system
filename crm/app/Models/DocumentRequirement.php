<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentRequirement extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'is_mandatory',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
