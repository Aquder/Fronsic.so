<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Source folder where the raw seed photos live inside the repo.
     * All seed images (users + posts) are bundled together in the same folder.
     * IMPORTANT: commit this folder to git so it exists on the server too,
     * since the seeder runs on the server, not locally.
     *
     * graduation_project/blog/database/seeders/images/posts/
     */
    protected string $sourceFolder = '';

    /**
     * Destination folder actually served by the app (storage/app/public/users).
     * Adjust this if user photos are served from a different sub-folder
     * (e.g. storage/app/public/avatars) to match how the app already saves them.
     */
    protected string $destinationFolder = '';

    public function __construct()
    {
        $this->sourceFolder = database_path('seeders/images/posts');
        $this->destinationFolder = storage_path('app/public/users');
    }

    public function run(): void
    {
        // Make sure the destination folder exists on the server before copying into it.
        File::ensureDirectoryExists($this->destinationFolder);

        $users = [
            [
                'name' => 'Ahmed Mohamed',
                'source_image' => 'photo_2_2026-07-22_03-07-32.jpg', // male
                'phone_number' => '01012345671',
                'national_id' => '29005121200011',
                'email' => 'Dr_ahmed@forensic.com',
                'date_of_birth' => '1985-03-14',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Sara Abdallah',
                'source_image' => 'photo_1_2026-07-22_03-07-32.jpg', // female
                'phone_number' => '01012345672',
                'national_id' => '29105121200022',
                'email' => 'sara.abdallah@forensic.test',
                'date_of_birth' => '1990-07-22',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Mohamed Ezzat',
                'source_image' => 'photo_5_2026-07-22_03-07-32.jpg', // male
                'phone_number' => '01012345673',
                'national_id' => '28805121200033',
                'email' => 'mohamed.ezzat@forensic.test',
                'date_of_birth' => '1982-11-02',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Mona Fathy',
                'source_image' => 'photo_6_2026-07-22_03-07-32.jpg', // female
                'phone_number' => '01012345674',
                'national_id' => '29305121200044',
                'email' => 'mona.fathy@forensic.test',
                'date_of_birth' => '1993-01-30',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Khaled Nour El-Din',
                'source_image' => 'photo_8_2026-07-22_03-07-32.jpg', // male
                'phone_number' => '01012345675',
                'national_id' => '28705121200055',
                'email' => 'khaled.noureldin@forensic.test',
                'date_of_birth' => '1987-05-18',
                'role' => 'doctor',
            ],
            [
                'name' => 'Dr. Yasmin Tarek',
                'source_image' => 'photo_7_2026-07-22_03-07-32.jpg', // female
                'phone_number' => '01012345676',
                'national_id' => '29405121200066',
                'email' => 'yasmin.tarek@forensic.test',
                'date_of_birth' => '1994-09-09',
                'role' => 'doctor',
            ],
            [
                'name' => 'Admin servies',
                'source_image' => 'photo_13_2026-07-22_03-07-32.jpg', // male - admin
                'phone_number' => '01012345677',
                'national_id' => '28405121200077',
                'email' => 'Admin@forensic.com',
                'date_of_birth' => '1980-12-25',
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            $storedFilename = $this->storeImage($user['source_image']);
            $imagepath= 'posts/' . $storedFilename;


            DB::table('users')->insert([
                'name' => $user['name'],
                'image' => $imagepath,
                'phone_number' => $user['phone_number'],
                'national_id' => $user['national_id'],
                'email' => $user['email'],
                'date_of_birth' => $user['date_of_birth'],
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('10201020'),
                'role' => $user['role'],
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now()->subDays(rand(60, 200)),
                'updated_at' => Carbon::now()->subDays(rand(0, 60)),
            ]);
        }
    }

    /**
     * Copy a bundled source photo into storage/app/public/users and return
     * the new stored filename (matching the app's real upload naming style).
     *
     * Falls back to null (no image) if the source file is missing, so the
     * seeder never breaks the run just because a photo wasn't committed.
     */
    protected function storeImage(string $sourceFilename): ?string
    {
        $sourcePath = $this->sourceFolder . DIRECTORY_SEPARATOR . $sourceFilename;

        if (! File::exists($sourcePath)) {
            $this->command?->warn("Seed image not found, skipping: {$sourcePath}");
            return null;
        }

        $extension = File::extension($sourcePath);
        $newFilename = Str::random(40) . '.' . $extension;
        $destinationPath = $this->destinationFolder . DIRECTORY_SEPARATOR . $newFilename;

        File::copy($sourcePath, $destinationPath);

        return $newFilename;
    }
}
