<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'title',
        'type',
        'image_url',
        'body',
        'room_type_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomCategory::class, 'room_type_id');
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'about' => 'About Hotel',
            'room_type' => 'Room Type',
            'nearby_place' => 'Nearby Place',
            'facility' => 'Facility',
            'event' => 'Event',
            'promotion' => 'Promotion',
            'policy' => 'Policy',
            default => ucfirst($this->type),
        };
    }
}
