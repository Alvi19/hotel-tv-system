<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'hotel_id',
        'room_number',
        'guest_name',
        'checkin',
        'checkout',
        'status'
    ];

    protected $casts = [
        'checkin' => 'datetime',
        'checkout' => 'datetime'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function device(): HasOne
    {
        return $this->hasOne(Device::class);
    }
}
