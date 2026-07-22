<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemLogSeeder extends Seeder
{
    public function run(): void
    {
        // The "name" column must hold the admin's name, not a generic event key.
        $adminName = DB::table('users')->where('role', 'admin')->value('name');

        // Fallback in case no admin exists yet (should not normally happen).
        $adminName = $adminName ?: 'System Administrator';

        $logMessages = [
            'Logged in to the platform.',
            'Logged out of the platform.',
            'Reviewed a newly created use case submitted by a doctor.',
            'Marked a use case as complete after review.',
            'Reviewed a new post published on the community platform.',
            'Removed a post that violated community guidelines.',
            'Reviewed a reported comment on a post.',
            'Monitored a new conversation started with the AI assistant.',
            'Approved a password reset request for a doctor account.',
            'Blocked a doctor account for violating platform policies.',
            'Reactivated a doctor account after review.',
            'Detected a failed login attempt using incorrect credentials.',
            'Updated platform settings.',
            'Reviewed weekly activity report for all doctors.',
            'Approved a new doctor registration on the platform.',
        ];

        foreach ($logMessages as $message) {
            // Insert each log message multiple times at different timestamps
            // to simulate ongoing admin activity on the platform.
            $repetitions = rand(2, 5);
            for ($i = 0; $i < $repetitions; $i++) {
                DB::table('system_logs')->insert([
                    'name' => $adminName,
                    'massage' => $message,
                    'created_at' => Carbon::now()->subDays(rand(0, 150))->subMinutes(rand(0, 1440)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 150)),
                ]);
            }
        }
    }
}
