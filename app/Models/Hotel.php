<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'logo_url',
        'background_image_url',
        'video_url',
        'text_running'
    ];

    // Relasi
    public function admins(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }

    public function shortcuts(): HasMany
    {
        return $this->hasMany(Shortcut::class);
    }

    public function hotelContents(): HasMany
    {
        return $this->hasMany(HotelContent::class);
    }
}
