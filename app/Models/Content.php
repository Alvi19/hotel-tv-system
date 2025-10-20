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
        'is_active',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }
}
