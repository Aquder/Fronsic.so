<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemLogSeeder extends Seeder
{
    public function run(): void
    {
        $logTemplates = [
            ['name' => 'user_login', 'massage' => 'Successful user login to the platform.'],
            ['name' => 'user_logout', 'massage' => 'User logged out of the platform.'],
            ['name' => 'use_case_created', 'massage' => 'A new use case was created by a doctor.'],
            ['name' => 'use_case_completed', 'massage' => 'A use case status was updated to complete.'],
            ['name' => 'post_published', 'massage' => 'A new post was published on the community platform.'],
            ['name' => 'post_deleted', 'massage' => 'A post was deleted by its owner.'],
            ['name' => 'comment_added', 'massage' => 'A new comment was added to a post.'],
            ['name' => 'ai_conversation_started', 'massage' => 'A user started a new conversation with the AI assistant.'],
            ['name' => 'password_reset', 'massage' => 'A password reset was requested for an account.'],
            ['name' => 'account_blocked', 'massage' => 'A user account was blocked by an administrator for policy violation.'],
            ['name' => 'account_reactivated', 'massage' => 'A user account was reactivated after review.'],
            ['name' => 'failed_login_attempt', 'massage' => 'A failed login attempt using incorrect credentials.'],
        ];

        foreach ($logTemplates as $log) {
            // Insert each log type multiple times at different timestamps to simulate real platform activity
            $repetitions = rand(2, 5);
            for ($i = 0; $i < $repetitions; $i++) {
                DB::table('system_logs')->insert([
                    'name' => $log['name'],
                    'massage' => $log['massage'],
                    'created_at' => Carbon::now()->subDays(rand(0, 150))->subMinutes(rand(0, 1440)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 150)),
                ]);
            }
        }
    }
}
