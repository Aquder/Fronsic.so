<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Source folder where the raw seed images live inside the repo.
     * IMPORTANT: commit this folder to git so it exists on the server too,
     * since the seeder runs on the server, not locally.
     *
     * graduation_project/blog/database/seeders/images/posts/
     */
    protected string $sourceFolder = '';

    /**
     * Destination folder actually served by the app (storage/app/public/posts).
     */
    protected string $destinationFolder = '';

    public function __construct()
    {
        $this->sourceFolder = database_path('seeders/images/posts');
        $this->destinationFolder = storage_path('app/public/posts');
    }

    public function run(): void
    {
        // Make sure the destination folder exists on the server before copying into it.
        File::ensureDirectoryExists($this->destinationFolder);

        // Original filenames of the raw images bundled inside database/seeders/images/posts/
        $articleImages = [
            'photo_4_2026-07-22_03-07-32.jpg',
            'photo_9_2026-07-22_03-07-32.jpg',
            'photo_11_2026-07-22_03-07-32.jpg',
            'photo_12_2026-07-22_03-07-32.jpg',
            'photo_14_2026-07-22_03-07-32.jpg',
            'photo_15_2026-07-22_03-07-32.jpg',
            'photo_16_2026-07-22_03-07-32.jpg',
            'photo_17_2026-07-22_03-07-32.jpg',
            'photo_18_2026-07-22_03-07-33.jpg',
            'photo_19_2026-07-22_03-07-33.jpg',
            'photo_20_2026-07-22_03-07-33.jpg',
            'photo_21_2026-07-22_03-07-33.jpg',
            'photo_22_2026-07-22_03-07-33.jpg',
            'photo_23_2026-07-22_03-07-33.jpg',
        ];

        // Article-type posts: title + content (an image will be attached)
        $articles = [
            [
                'title' => 'Fundamentals of Determining Time of Death in Forensic Medicine',
                'content' => 'Determining time of death relies on several physiological indicators, most notably rigor mortis, livor mortis, and body temperature decline. These indicators are combined with surrounding environmental conditions to reach an accurate time estimate that helps criminal investigations narrow down suspicion.',
            ],
            [
                'title' => 'The Role of DNA Analysis in Modern Criminal Cases',
                'content' => 'DNA analysis has revolutionized identity verification and linking evidence to perpetrators. Using precise samples such as hair, saliva, or blood, it is now possible to determine identity with extremely high accuracy, helping reopen many cold cases that remained unsolved for years.',
            ],
            [
                'title' => 'Bloodstain Pattern Analysis and Crime Scene Reconstruction',
                'content' => 'By studying the shape, direction, and size of bloodstains at a crime scene, a forensic expert can deduce the angle of injury, the position of the perpetrator and victim, and even the full sequence of events, a discipline scientifically known as bloodstain pattern analysis.',
            ],
            [
                'title' => 'Poisoning: How Does a Forensic Doctor Detect Toxic Substances in the Body?',
                'content' => 'Detecting poisoning relies on toxicological chemical analysis of blood, urine, and tissues. These tests help identify the type of toxic substance and its concentration, and whether the dose was sufficient to cause death or merely a contributing factor.',
            ],
            [
                'title' => 'The Difference Between Defensive Wounds and Assault Wounds',
                'content' => 'Defensive wounds usually appear on the palms and forearms as a result of the victim attempting to fend off an attack, while assault wounds concentrate on vital areas such as the chest and neck. Distinguishing between the two helps understand the dynamics of the incident and whether the victim resisted.',
            ],
            [
                'title' => 'The Lung Float Test and Determining Live Birth',
                'content' => 'The lung float test is used to verify whether a newborn breathed after birth, by placing lung tissue in water and observing whether it floats. This test is an important tool in cases of suspected newborn death.',
            ],
            [
                'title' => 'Gunshot Wounds: Determining Distance and Direction',
                'content' => 'Examining gunpowder residue around an entry wound can reveal the approximate distance between the firing source and the victim, while tracing the projectile path inside the body helps determine the angle and direction of the shot, aiding in reconstructing the crime scene.',
            ],
            [
                'title' => 'The Role of Insects in Estimating Time of Death (Forensic Entomology)',
                'content' => 'Forensic entomology relies on studying the life cycle of insects that colonize bodies to estimate the time elapsed since death, especially in advanced decomposition cases where traditional methods fail to provide an accurate estimate.',
            ],
            [
                'title' => 'Radiological Examination of Bodies: A Modern Tool in Forensic Autopsy',
                'content' => 'Computed tomography has become an essential part of modern forensic examination, allowing detection of fractures, foreign objects, and projectile paths without requiring a full traditional autopsy, providing accurate, non-invasive documentation of injuries.',
            ],
            [
                'title' => 'Identity Verification Through Dental Records',
                'content' => 'Dental examination is used as a reliable tool for identifying severely damaged or decomposed bodies, by comparing missing persons\' dental records with the existing dental details, given the uniqueness of fillings and dental work for each person.',
            ],
            [
                'title' => 'Asphyxiation: Types and Diagnostic Signs',
                'content' => 'Asphyxiation is divided into several types, most notably hanging, manual strangulation, and ligature strangulation. Diagnostic signs vary between types in terms of the shape and direction of the mark around the neck, and the presence or absence of petechial hemorrhage in the eyes and face.',
            ],
            [
                'title' => 'Ethical Challenges in Forensic Medicine Practice',
                'content' => 'Forensic doctors face multiple ethical challenges related to complete neutrality in reports, handling victims\' families with sensitivity, and maintaining confidentiality of information until judicial investigations conclude, requiring continuous training on professional ethics.',
            ],
            [
                'title' => 'Postmortem Burns Versus Antemortem Burns',
                'content' => 'A forensic doctor distinguishes between burns that occurred during life and those that occurred after death through the presence or absence of vital response signs such as redness and swelling, in addition to the presence of soot in the respiratory tract as evidence of smoke inhalation while alive.',
            ],
            [
                'title' => 'The Importance of Photographic Documentation at the Crime Scene',
                'content' => 'Accurate photographic documentation of the crime scene and injuries is a crucial step that cannot be overlooked, as it provides a permanent visual record that can be referenced during trial, and helps other experts review the case without needing to re-examine the body.',
            ],
        ];

        // Feed-type posts: short text content only, no title or image
        $feeds = [
            "Today's lecture on bloodstain pattern analysis was fascinating, details I hadn't fully appreciated before.",
            "A new case arrived at the lab today, quite challenging in pinpointing the exact cause of death.",
            'Advice for new colleagues: precise documentation of the scene saves you a lot of time and effort in the final report.',
            'Has anyone here used forensic entomology to estimate time of death? Would love to hear practical experiences.',
            "Next week's workshop will cover CT imaging techniques in forensic autopsy, don't miss it.",
            'Humane treatment of victims\' families matters just as much as scientific accuracy in examination.',
            'Sharing a useful article I posted today about the lung float test.',
            'First time working on a fully burned case, the biggest challenge was determining cause of death before or after the fire.',
            'Thanks to everyone who joined the discussion under the DNA analysis article, really valuable input.',
            'Maintaining confidentiality in sensitive cases is a professional foundation we can never compromise on.',
            "There's a new update to sample collection protocols, I'll try to summarize it in an upcoming post.",
            'Long day at the lab but the results finally came out clear.',
            'Looking for a recent reference on gunshot wound analysis if anyone has a suggestion.',
            'Collaboration between forensic doctors and investigators makes a huge difference in reaching the truth faster.',
            'Attended an online conference on developments in forensic toxicology, some info worth sharing.',
            'Reviewing an old cold case today with fresh eyes using updated DNA techniques.',
            'A reminder to always double-check chain of custody documentation before submitting evidence.',
            'Interesting discussion in the community today about postmortem interval estimation methods.',
        ];

        $users = DB::table('users')->get(['id']);
        $imageIndex = 0;

        foreach ($users as $user) {
            $postCount = rand(4, 6);

            for ($i = 0; $i < $postCount; $i++) {
                $isArticle = rand(0, 1) === 1;
                $createdAt = Carbon::now()->subDays(rand(1, 150));

                if ($isArticle) {
                    $article = $articles[array_rand($articles)];

                    // Pick the next source image (cycling through the pool) and
                    // physically copy it into storage/app/public/posts with a
                    // fresh random name, exactly like a real upload would.
                    $sourceFilename = $articleImages[$imageIndex % count($articleImages)];
                    $imageIndex++;

                    $storedFilename = $this->storeImage($sourceFilename);

                    DB::table('posts')->insert([
                        'title' => $article['title'],
                        'content' => $article['content'],
                        'user_id' => $user->id,
                        'image' => $storedFilename,
                        'type' => 'article',
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt->copy()->addDays(rand(0, 5)),
                    ]);
                } else {
                    $feedContent = $feeds[array_rand($feeds)];

                    DB::table('posts')->insert([
                        'title' => null,
                        'content' => $feedContent,
                        'user_id' => $user->id,
                        'image' => null,
                        'type' => 'feeds',
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt->copy()->addDays(rand(0, 5)),
                    ]);
                }
            }
        }
    }

    /**
     * Copy a bundled source image into storage/app/public/posts and return
     * the new stored filename (matching the app's real upload naming style).
     *
     * Falls back to null (no image) if the source file is missing, so the
     * seeder never breaks the run just because an image wasn't committed.
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
