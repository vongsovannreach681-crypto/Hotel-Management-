<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin user
        User::firstOrCreate(
            ['email' => 'reach@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Reach321'),
                'role' => 'admin',
            ]
        );

        $hotels = [
            [
                'name' => 'Sokha Hotels',
                'location' => 'Phnom Penh, Cambodia',
                'room_count' => 20,
                'price_per_night' => 300.00,
                'description' => 'Good View with a Mekong River',
                'image' => 'https://images.trvl-media.com/lodging/1000000/30000/23700/23624/8368e710.jpg?impolicy=resizecrop&rw=575&rh=575&ra=fill',
                'status' => 'available',
                'available' => true,
            ],
            [
                'name' => 'Setec',
                'location' => 'Hotel',
                'room_count' => 100,
                'price_per_night' => 200.00,
                'description' => 'Good View',
                'image' => 'https://www.ca.kayak.com/rimg/dimg/dynamic/186/2023/08/295ffd3a54bd51fc33810ce59382d1da.webp',
                'status' => 'available',
                'available' => true,
            ],
            [
                'name' => 'TPN',
                'location' => 'Phnom Penh, Cambodia',
                'room_count' => 100,
                'price_per_night' => 300.00,
                'description' => 'Comfortable luxury rooms with modern amenities.',
                'image' => 'https://minibreaks.in/upload_images/1c6b47482acfb2f7641859bd1cc66872.jpg',
                'status' => 'available',
                'available' => true,
            ],
            [
                'name' => 'Deluxe Room',
                'location' => 'Phnom Penh',
                'room_count' => 20,
                'price_per_night' => 150.00,
                'description' => 'Elegant suite with city views and premium bedding.',
                'image' => 'https://cdn.britannica.com/96/115096-050-5AFDAF5D/Bellagio-Hotel-Casino-Las-Vegas.jpg',
                'status' => 'available',
                'available' => true,
            ],
        ];

        foreach ($hotels as $data) {
            Hotel::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
