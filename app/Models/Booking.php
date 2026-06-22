<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'booking_date',
        'requester_name',
        'requester_role',
        'event_name',
        'time_range',
        'users_count',
        'status',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'users_count' => 'integer',
        ];
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
