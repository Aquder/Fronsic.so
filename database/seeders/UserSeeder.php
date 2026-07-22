<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Dr. Ahmed El-Sherif',
                'image' => 'photo_2_2026-07-22_03-07-32.jpg', // male
                'phone_number' => '01012345671',
                'national_id' => '29005121200011',
                'email' => 'ahmed.elsherif@forensic.test',
                'date_of_birth' => '1985-03-14',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Sara Abdallah',
                'image' => 'photo_1_2026-07-22_03-07-32.jpg', // female
                'phone_number' => '01012345672',
                'national_id' => '29105121200022',
                'email' => 'sara.abdallah@forensic.test',
                'date_of_birth' => '1990-07-22',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Mohamed Ezzat',
                'image' => 'photo_5_2026-07-22_03-07-32.jpg', // male
                'phone_number' => '01012345673',
                'national_id' => '28805121200033',
                'email' => 'mohamed.ezzat@forensic.test',
                'date_of_birth' => '1982-11-02',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Mona Fathy',
                'image' => 'photo_6_2026-07-22_03-07-32.jpg', // female
                'phone_number' => '01012345674',
                'national_id' => '29305121200044',
                'email' => 'mona.fathy@forensic.test',
                'date_of_birth' => '1993-01-30',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Khaled Nour El-Din',
                'image' => 'photo_8_2026-07-22_03-07-32.jpg', // male
                'phone_number' => '01012345675',
                'national_id' => '28705121200055',
                'email' => 'khaled.noureldin@forensic.test',
                'date_of_birth' => '1987-05-18',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Yasmin Tarek',
                'image' => 'photo_7_2026-07-22_03-07-32.jpg', // female
                'phone_number' => '01012345676',
                'national_id' => '29405121200066',
                'email' => 'yasmin.tarek@forensic.test',
                'date_of_birth' => '1994-09-09',
                'role' => 'doctor',
            ],
            [
                'name' => 'Eng. Ahmed mohamed',
                'image' => 'photo_2026-07-22_03-46-47.jpg', // male - admin
                'phone_number' => '01012345677',
                'national_id' => '28405121200077',
                'email' => 'omar.hassan@forensic.test',
                'date_of_birth' => '1980-12-25',
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'image' => $user['image'],
                'phone_number' => $user['phone_number'],
                'national_id' => $user['national_id'],
                'email' => $user['email'],
                'date_of_birth' => $user['date_of_birth'],
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'role' => $user['role'],
                'remember_token' => \Illuminate\Support\Str::random(10),
                'created_at' => Carbon::now()->subDays(rand(60, 200)),
                'updated_at' => Carbon::now()->subDays(rand(0, 60)),
            ]);
        }
    }
}
