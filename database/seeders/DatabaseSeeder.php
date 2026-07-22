<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Order matters because of foreign key constraints:
     * Users -> UseCases -> Posts -> Interactions (Likes/Comments/Views) -> Conversations/Messages -> SystemLogs
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UseCaseSeeder::class,
            PostSeeder::class,
            InteractionSeeder::class,
            ConversationSeeder::class,
            SystemLogSeeder::class,
        ]);
    }
}
