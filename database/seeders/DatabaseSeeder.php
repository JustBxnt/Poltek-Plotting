<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default login accounts for testing.
        foreach ([
            ['name' => 'Mahasiswa Test', 'email' => 'mahasiswa@polinema.ac.id'],
            ['name' => 'Dosen Test', 'email' => 'dosen@polinema.ac.id'],
            ['name' => 'Umum Test', 'email' => 'umum@polinema.ac.id'],
        ] as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => bcrypt('Password123'),
                ]
            );
        }

        foreach ([
            ['code' => 'AA', 'name' => 'Gedung AA', 'info' => 'Ruang rapat pimpinan', 'kind' => 'building', 'is_active' => true],
            ['code' => 'AH', 'name' => 'Gedung AH', 'info' => 'Ruang administrasi dan pertemuan', 'kind' => 'building', 'is_active' => true],
            ['code' => 'AK', 'name' => 'Gedung AK', 'info' => 'Pusat riset dan kerja praktek', 'kind' => 'building', 'is_active' => true],
            ['code' => 'AJ', 'name' => 'Gedung AJ', 'info' => 'Area layanan akademik dan kegiatan mahasiswa', 'kind' => 'building', 'is_active' => true],
            ['code' => 'AM', 'name' => 'Gedung AM', 'info' => 'Fasilitas penunjang dan ruang kolaborasi', 'kind' => 'building', 'is_active' => true],
            ['code' => 'AUPER', 'name' => 'Aula Pertamina (AUPER)', 'info' => 'Tempat kegiatan dan acara kampus skala besar.', 'kind' => 'facility', 'is_active' => true],
            ['code' => 'GRAPOL', 'name' => 'Graha Polinema (Grapol)', 'info' => 'Gedung serbaguna untuk acara resmi dan umum.', 'kind' => 'facility', 'is_active' => true],
            ['code' => 'GRATER', 'name' => 'Graha Theater (GRATER)', 'info' => 'Ruang pertunjukan, seminar, dan kegiatan publik.', 'kind' => 'facility', 'is_active' => true],
            ['code' => 'MR-DEPAN', 'name' => 'Masjid Raya depan', 'info' => 'Akses tempat ibadah di area depan kampus.', 'kind' => 'facility', 'is_active' => true],
            ['code' => 'MR-TENGAH', 'name' => 'Masjid Raya Tengah', 'info' => 'Akses tempat ibadah di area tengah kampus.', 'kind' => 'facility', 'is_active' => true],
            ['code' => 'LMS', 'name' => 'Lapangan Mini Soccer', 'info' => 'Area olahraga dan aktivitas fisik.', 'kind' => 'facility', 'is_active' => true],
            ['code' => 'LV', 'name' => 'Lapangan Voli', 'info' => 'Area olahraga untuk kegiatan umum.', 'kind' => 'facility', 'is_active' => true],
            ['code' => 'LU', 'name' => 'Lapangan Upacara', 'info' => 'Area apel dan kegiatan seremonial kampus.', 'kind' => 'facility', 'is_active' => true],
        ] as $building) {
            Building::updateOrCreate(
                ['code' => $building['code']],
                [
                    'name' => $building['name'],
                    'info' => $building['info'],
                    'kind' => $building['kind'],
                    'is_active' => $building['is_active'],
                ]
            );
        }

        $buildingAA = Building::query()->where('code', 'AA')->first();

        if ($buildingAA) {
            foreach ([2, 4, 6, 9, 11, 14, 18, 21, 24, 27, 29] as $day) {
                Booking::updateOrCreate(
                    [
                        'building_id' => $buildingAA->id,
                        'booking_date' => Carbon::today()->copy()->day($day)->toDateString(),
                    ],
                    [
                        'requester_name' => 'System Seed',
                        'event_name' => 'Booked',
                        'time_range' => '09:00 - 11:00',
                        'users_count' => 10,
                        'status' => 'approved',
                    ]
                );
            }
        }
    }
}
