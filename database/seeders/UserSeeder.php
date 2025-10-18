<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Device;
use App\Models\Hotel;
use App\Models\HotelContent;
use App\Models\Room;
use App\Models\Shortcut;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1️⃣ Buat hotel sample
        $hotel = Hotel::create([
            'name' => 'Grand Savanna Hotel',
            'description' => 'Hotel bintang 4 dengan fasilitas lengkap.',
            'address' => 'Jl. Margonda Raya No. 10, Depok',
            'phone' => '+62 21 555 1234',
            'email' => 'info@savannahotel.com',
            'website' => 'https://savannahotel.com',
            'logo_url' => 'uploads/logos/hotel_logo.png',
            'background_image_url' => 'uploads/backgrounds/hotel_bg.jpg',
        ]);

        // 2️⃣ Buat IT Admin (dari pihak kita)
        User::create([
            'name' => 'it_admin',
            'email' => 'it_admin@hotel.com',
            'password' => Hash::make('password123'),
            'role' => 'it_admin',
            'hotel_id' => null,
        ]);

        // 3️⃣ Buat Staff Hotel
        User::create([
            'name' => 'hotel_staff',
            'email' => 'hotel_staff@hotel.com',
            'password' => Hash::make('password123'),
            'role' => 'hotel_staff',
            'hotel_id' => $hotel->id,
        ]);

        // 4️⃣ Tambahkan Room Sample
        $rooms = [
            ['hotel_id' => $hotel->id, 'room_number' => '101', 'status' => 'available'],
            ['hotel_id' => $hotel->id, 'room_number' => '102', 'status' => 'available'],
            ['hotel_id' => $hotel->id, 'room_number' => '103', 'status' => 'maintenance'],
        ];
        Room::insert($rooms);

        // 5️⃣ Tambahkan 1 Device (STB) terhubung ke Room 101
        Device::create([
            'hotel_id' => $hotel->id,
            'room_id' => Room::where('room_number', '101')->first()->id,
            'device_id' => 'STB-101-A',
            'status' => 'offline',
        ]);

        // 6️⃣ Tambahkan 1 Banner
        Banner::create([
            'hotel_id' => $hotel->id,
            'title' => 'Selamat Datang di Grand Savanna Hotel',
            'description' => 'Nikmati kenyamanan dan kemewahan terbaik selama Anda menginap.',
            'image_url' => 'uploads/banners/welcome.jpg',
            'is_active' => true,
        ]);

        // 7️⃣ Tambahkan Shortcut (menu bawah STB)
        Shortcut::insert([
            [
                'hotel_id' => $hotel->id,
                'title' => 'YouTube',
                'icon_url' => 'uploads/icons/youtube.png',
                'type' => 'youtube',
                'target' => 'https://www.youtube.com',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'hotel_id' => $hotel->id,
                'title' => 'Netflix',
                'icon_url' => 'uploads/icons/netflix.png',
                'type' => 'netflix',
                'target' => 'https://www.netflix.com',
                'order_no' => 2,
                'is_active' => true,
            ],
        ]);

        // 8️⃣ Tambahkan Content (About Hotel, Facilities)
        HotelContent::insert([
            [
                'hotel_id' => $hotel->id,
                'category' => 'About',
                'title' => 'Tentang Hotel Kami',
                'content' => 'Grand Savanna Hotel adalah hotel modern dengan fasilitas lengkap di jantung kota Depok.',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'hotel_id' => $hotel->id,
                'category' => 'Facilities',
                'title' => 'Fasilitas Unggulan',
                'content' => 'Kolam renang, spa, gym, dan restoran 24 jam tersedia untuk kenyamanan Anda.',
                'order_no' => 2,
                'is_active' => true,
            ],
        ]);

        $this->command->info('✅ Data IT Admin, Staff Hotel, dan sample data berhasil dibuat!');
    }
}
