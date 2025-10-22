<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat satu Super Admin user dan rolenya.
     */
    public function run(): void
    {
        $hotel = Hotel::firstOrCreate(
            ['email' => 'info@grandhotel.com'],
            [
                'name' => 'Grand Hotel Indonesia',
                'description' => 'Hotel bintang 5 dengan fasilitas lengkap di pusat kota.',
                'address' => 'Jl. MH Thamrin No. 1, Jakarta Pusat',
                'phone' => '+62 21 1234567',
                'website' => 'https://grandhotel.com',
                'logo_url' => '/images/logo.png',
                'background_image_url' => '/images/background.jpg',
                'video_url' => '/videos/hotel.mp4',
            ]
        );

        // Buat Role Super Admin (jika belum ada)
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'display_name' => 'Super Admin',
                'scope' => 'global',
                'hotel_id' => null,
                'created_by' => null,
            ]
        );

        // Buat User Super Admin (jika belum ada)
        $user = User::updateOrCreate(
            ['email' => 'superadmin@hotel.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role_id' => $superAdminRole->id,
                'hotel_id' => null,
            ]
        );

        $this->command->info('🏨 Hotel created: ' . $hotel->name);
        $this->command->info('✅ Super Admin user dan role berhasil dibuat!');
        $this->command->info('Email: ' . $user->email);
        $this->command->info('Password: password123');
    }
}
