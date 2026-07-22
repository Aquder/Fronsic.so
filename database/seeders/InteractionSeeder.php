<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InteractionSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            'Really valuable information, thanks for sharing.',
            'This is definitely a topic that needs more awareness among colleagues.',
            'I had a similar case last month, your analysis is spot on.',
            'Could you recommend a good reference to read more about this?',
            'Clear and concise explanation, great work doctor.',
            "I don't fully agree on the time estimation point, there are other factors to consider.",
            'What do you think about using CT imaging instead of traditional autopsy here?',
            'This really helped me prepare a lecture I was working on.',
            'Great case, would love to hear more details if possible.',
            'Appreciate the effort put into this documentation.',
            'This matches what we were taught during residency, good refresher.',
            'Interesting perspective, hadn\'t considered that angle before.',
            'Do you have any updated guidelines on this procedure?',
            'Well documented, this should be required reading for junior staff.',
            'Thanks for the detailed breakdown, very helpful for my current case.',
        ];

        $posts = DB::table('posts')->get(['id', 'user_id']);
        $userIds = DB::table('users')->pluck('id')->all();

        foreach ($posts as $post) {
            // ===== Likes (boosted volume) =====
            $possibleLikers = array_values(array_diff($userIds, [$post->user_id]));
            shuffle($possibleLikers);
            $likeCount = rand(3, min(6, count($possibleLikers)));
            $likers = array_slice($possibleLikers, 0, $likeCount);

            foreach ($likers as $likerId) {
                DB::table('likes')->insert([
                    'post_id' => $post->id,
                    'user_id' => $likerId,
                    'created_at' => Carbon::now()->subDays(rand(0, 100)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 100)),
                ]);
            }

            // ===== Comments (boosted volume) =====
            $commentCount = rand(2, 6);
            for ($i = 0; $i < $commentCount; $i++) {
                $commenterId = $userIds[array_rand($userIds)];

                DB::table('comments')->insert([
                    'comment' => $comments[array_rand($comments)],
                    'post_id' => $post->id,
                    'user_id' => $commenterId,
                    'created_at' => Carbon::now()->subDays(rand(0, 100)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 100)),
                ]);
            }

            // ===== Views (boosted volume) =====
            // Mix of registered-user views and guest views (user_id = null with IP)
            $viewCount = rand(10, 30);
            for ($i = 0; $i < $viewCount; $i++) {
                $isGuestView = rand(0, 100) < 30; // 30% guest views

                DB::table('views')->insert([
                    'post_id' => $post->id,
                    'user_id' => $isGuestView ? null : $userIds[array_rand($userIds)],
                    'ip' => $isGuestView
                        ? rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255)
                        : null,
                    'created_at' => Carbon::now()->subDays(rand(0, 100)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 100)),
                ]);
            }
        }
    }
}
