<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shortcut extends Model
{
    use HasFactory;

    protected $table = 'shortcuts';

    protected $fillable = [
        'hotel_id',
        'title',
        'icon_url',
        'type',
        'target',
        'order_no',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }
}
