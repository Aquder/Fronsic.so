<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConversationSeeder extends Seeder
{
    public function run(): void
    {
        // Each item: conversation title + a set of alternating user/assistant messages
        $conversationPool = [
            [
                'title' => 'Question about determining time of death',
                'messages' => [
                    ['sender' => 'user', 'content' => 'What are the most accurate methods to determine time of death in cases where more than 48 hours have passed?'],
                    ['sender' => 'assistant', 'content' => 'After 48 hours, traditional indicators like rigor mortis and livor mortis become less reliable, so the focus shifts to decomposition stage and forensic entomology, along with measuring potassium levels in the vitreous humor of the eye as an additional marker.'],
                    ['sender' => 'user', 'content' => 'Is body temperature still useful after that period?'],
                    ['sender' => 'assistant', 'content' => 'Practically, temperature readings lose accuracy after about 24 hours because the body reaches thermal equilibrium with the surrounding environment, making them unreliable for estimating time in later-stage cases.'],
                ],
            ],
            [
                'title' => 'Toxicology analysis question',
                'messages' => [
                    ['sender' => 'user', 'content' => 'What are the best samples for toxicology analysis when the body is in an advanced state of decomposition?'],
                    ['sender' => 'assistant', 'content' => 'In advanced decomposition, it\'s best to collect bone marrow, hair, nails, and adipose tissue, since these are more resistant to decay compared to blood and urine, which degrade quickly during putrefaction.'],
                    ['sender' => 'user', 'content' => 'Does hair help determine the duration of toxin exposure?'],
                    ['sender' => 'assistant', 'content' => 'Exactly, hair grows at a fairly constant monthly rate, so analyzing different segments can reveal the exposure pattern over time, whether it was chronic or a single acute dose.'],
                ],
            ],
            [
                'title' => 'Consultation on gunshot wound injuries',
                'messages' => [
                    ['sender' => 'user', 'content' => 'How do I differentiate between entry and exit wounds in a gunshot case?'],
                    ['sender' => 'assistant', 'content' => 'Entry wounds are usually smaller with regular edges and may show soot or stippling if the shot was fired at close range, while exit wounds are typically larger and irregular with no gunpowder residue.'],
                    ['sender' => 'user', 'content' => 'Why is determining the firing distance important?'],
                    ['sender' => 'assistant', 'content' => 'Determining the distance helps distinguish between suicide and homicide, since very close-range or contact wounds are more consistent with suicide, while wounds from a distance suggest an assault by another party.'],
                ],
            ],
            [
                'title' => 'Question about the lung float test',
                'messages' => [
                    ['sender' => 'user', 'content' => 'Can you explain in detail the steps of the lung float test in suspected newborn death cases?'],
                    ['sender' => 'assistant', 'content' => 'The entire lungs are extracted and placed in a container of water to observe flotation, then small sections from each lobe are cut and retested. If the tissue floats, it indicates the alveoli contained air from breathing after birth, while sinking suggests stillbirth.'],
                    ['sender' => 'user', 'content' => 'Are there factors that can give a false result in this test?'],
                    ['sender' => 'assistant', 'content' => 'Yes, putrefactive gas formation can cause false flotation even if the newborn never breathed, so the result must always be interpreted alongside detailed histological examination of the lung and the overall condition of the body.'],
                ],
            ],
            [
                'title' => 'Discussion on bloodstain analysis',
                'messages' => [
                    ['sender' => 'user', 'content' => 'What factors affect the shape of a bloodstain at a crime scene?'],
                    ['sender' => 'assistant', 'content' => 'The stain shape is affected by the angle of impact, the height of the bleeding source, and the type of surface it lands on. A more vertical angle produces a rounder stain, while an oblique angle creates an elongated shape in the direction of travel.'],
                    ['sender' => 'user', 'content' => 'Can I determine the direction the perpetrator moved from this?'],
                    ['sender' => 'assistant', 'content' => 'Indeed, studying the direction of the elongated tail of the stain reveals the direction of travel of the blood source, and by analyzing multiple stains together, you can reconstruct the approximate point of origin in three-dimensional space.'],
                ],
            ],
            [
                'title' => 'Question about asphyxiation and strangulation',
                'messages' => [
                    ['sender' => 'user', 'content' => 'What is the difference between hanging marks and manual strangulation marks on the neck?'],
                    ['sender' => 'assistant', 'content' => 'In hanging, the mark is typically oblique, forming a V-shape rising toward the suspension point, and usually incomplete at the back of the neck. In manual strangulation, multiple irregular bruises and scratches appear from direct finger pressure applied horizontally on the neck.'],
                    ['sender' => 'user', 'content' => 'Does petechial hemorrhage appear in both cases?'],
                    ['sender' => 'assistant', 'content' => 'Petechial hemorrhage appears more clearly in manual and ligature strangulation due to continued venous obstruction while arteries remain partially open, whereas it may be less apparent in complete hanging due to rapid total circulatory cutoff.'],
                ],
            ],
            [
                'title' => 'Question about handling fire-related cases',
                'messages' => [
                    ['sender' => 'user', 'content' => 'How do I confirm the person was alive during the fire rather than already deceased?'],
                    ['sender' => 'assistant', 'content' => 'The key evidence is detecting elevated carbon monoxide levels in the blood, since smoke inhalation only occurs while alive. The presence of soot inside the respiratory tract and larynx also supports that the person was breathing during the fire.'],
                    ['sender' => 'user', 'content' => 'What if there\'s no carbon monoxide in the blood?'],
                    ['sender' => 'assistant', 'content' => 'In that case, it\'s likely death occurred before the fire started, and the fire may have been used to conceal an earlier crime, which requires a careful examination for injuries or other causes of death predating the fire.'],
                ],
            ],
            [
                'title' => 'Question about forensic entomology',
                'messages' => [
                    ['sender' => 'user', 'content' => 'How are insects used to estimate time of death?'],
                    ['sender' => 'assistant', 'content' => 'Blowflies lay eggs on a body within a few hours of death, and by understanding the larval life cycle and growth rate at the prevailing temperature, you can calculate the time elapsed since egg-laying, and thus estimate the approximate time since death.'],
                    ['sender' => 'user', 'content' => 'Is this method accurate under all conditions?'],
                    ['sender' => 'assistant', 'content' => 'Accuracy is affected by factors like local temperature and whether the body was in an enclosed or open space, so it\'s always best to collect live insect samples from the scene and rear them in the lab to compare growth against actual conditions rather than relying solely on general charts.'],
                ],
            ],
        ];

        $users = DB::table('users')->get(['id']);

        foreach ($users as $user) {
            $conversationCount = rand(3, 5);
            $selectedConversations = collect($conversationPool)->shuffle()->take($conversationCount);

            foreach ($selectedConversations as $conv) {
                $convCreatedAt = Carbon::now()->subDays(rand(1, 120));

                $conversationId = DB::table('conversations')->insertGetId([
                    'user_id' => $user->id,
                    'title' => $conv['title'],
                    'created_at' => $convCreatedAt,
                    'updated_at' => $convCreatedAt->copy()->addMinutes(rand(5, 60)),
                ]);

                $messageTime = $convCreatedAt->copy();

                foreach ($conv['messages'] as $msg) {
                    $messageTime = $messageTime->copy()->addSeconds(rand(10, 120));

                    DB::table('messages')->insert([
                        'conversation_id' => $conversationId,
                        'sender' => $msg['sender'],
                        'content' => $msg['content'],
                        'metadata' => $msg['sender'] === 'assistant'
                            ? json_encode(['model' => 'forensic-assistant-v1', 'tokens' => rand(60, 300)])
                            : null,
                        'created_at' => $messageTime,
                        'updated_at' => $messageTime,
                    ]);
                }
            }
        }
    }
}
