<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama (Menggunakan firstOrCreate agar tidak error duplikat jika di-seed ulang)
        $admin = User::firstOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name' => 'Admin Amikom',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // 2. Insert Kategori Event
        $category = Category::firstOrCreate([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $category2 = Category::firstOrCreate([
            'name' => 'Entertaiment',
            'slug' => 'entertaiment',
        ]);

        $category3 = Category::firstOrCreate([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        // 3. Insert Sampel Events (Menggunakan firstOrCreate berdasarkan judul agar aman dijalankan berkali-kali)
        
        // Event 1
        Event::firstOrCreate(
            ['title' => 'Jazz Night 2025'],
            [
                'category_id' => $category2->id,
                'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
                'date' => '2026-05-10 19:00:00',
                'location' => 'Amikom Baru',
                'price' => 50000,
                'stock' => 100,
                'poster_path' => 'posters/event-1.png',
            ]
        );

        // Event 2
        Event::firstOrCreate(
            ['title' => 'Hackaton - Unleash Your Inner Developer'],
            [
                'category_id' => $category->id,
                'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
                'date' => '2026-05-05 10:00:00',
                'location' => 'Inkubator Amikom',
                'price' => 50000,
                'stock' => 100,
                'poster_path' => 'posters/event-2.png',
            ]
        );

        // Event 3
        Event::firstOrCreate(
            ['title' => 'AI & FUTURE TECH SUMMIT 2026'],
            [
                'category_id' => $category->id,
                'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
                'date' => '2026-05-01 13:00:00',
                'location' => 'Cinema Unit 6',
                'price' => 50000,
                'stock' => 100,
                'poster_path' => 'posters/event-3.png',
            ]
        );

        // Event 4
        Event::firstOrCreate(
            ['title' => 'Digital Marketing Seminar'],
            [
                'category_id' => $category->id,
                'description' => 'Belajar strategi pemasaran digital modern.',
                'date' => '2026-06-05 13:00:00',
                'location' => 'Ruang Seminar',
                'price' => 50000,
                'stock' => 80,
                'poster_path' => 'posters/event-4.png',
            ]
        );

        // Event 5
        Event::firstOrCreate(
            ['title' => 'Laravel Bootcamp'],
            [
                'category_id' => $category3->id,
                'description' => 'Belajar Laravel dari dasar sampai mahir.',
                'date' => '2026-06-10 09:00:00',
                'location' => 'Lab Komputer',
                'price' => 100000,
                'stock' => 50,
                'poster_path' => 'posters/event-5.png',
            ]
        );

        // Event 6
        Event::firstOrCreate(
            ['title' => 'Mobile App Workshop'],
            [
                'category_id' => $category3->id,
                'description' => 'Membuat aplikasi mobile menggunakan Flutter.',
                'date' => '2026-06-12 09:00:00',
                'location' => 'Lab Mobile',
                'price' => 90000,
                'stock' => 50,
                'poster_path' => 'posters/event-6.png',
            ]
        );

        // Event 7
        Event::firstOrCreate(
            ['title' => 'E-Sport U-Champ'],
            [
                'category_id' => $category2->id,
                'description' => 'Turnamen game antar mahasiswa.',
                'date' => '2026-06-15 15:00:00',
                'location' => 'Auditorium',
                'price' => 30000,
                'stock' => 200,
                'poster_path' => 'posters/event-7.png',
            ]
        );
    }
}