<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'hotel_id',
        'title',
        'description',
        'image_url',
        'active_from',
        'active_to',
        'is_active'
    ];

    protected $casts = [
        'active_from' => 'datetime',
        'active_to' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getStatusAttribute()
    {
        $today = now()->toDateString();
        if (!$this->active_from || !$this->active_to) return 'Scheduled';
        if ($this->active_to < $today) return 'Expired';
        if ($this->active_from > $today) return 'Upcoming';
        return 'Active';
    }
}
