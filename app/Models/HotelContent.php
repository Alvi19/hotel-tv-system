<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelContent extends Model
{
    use HasFactory;

    protected $table = 'hotel_contents';

    protected $fillable = [
        'hotel_id',
        'category',
        'title',
        'content',
        'image_url',
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
}
