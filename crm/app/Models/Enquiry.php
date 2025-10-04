<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    protected $fillable = [
        'customer_name',
        'mobile_number',
        'service_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getEstimatedCompletionDateAttribute()
    {
        $days = $this->service?->expected_completion_days;
        if ($days === null) {
            return null;
        }
        $base = $this->created_at ?? now();
        return $base->copy()->addDays((int) $days);
    }
}
