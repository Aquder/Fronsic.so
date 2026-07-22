<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UseCaseSeeder extends Seeder
{
    public function run(): void
    {
        $caseTemplates = [
            [
                'name' => 'Suspected Death by Drowning',
                'description' => 'A male adult body was found in a river near a residential area. Examination of the lungs revealed frothy fluid in the airways, supporting the hypothesis of vital drowning. Blood and tissue samples were taken for diatom testing to confirm whether drowning occurred before or after death, noting the absence of visible defensive injuries.',
            ],
            [
                'name' => 'Sharp Object Injury Case',
                'description' => 'A report was received regarding a fatal stabbing case, with a penetrating wound observed in the chest area at a depth of approximately 12 cm. The entry angle suggests the perpetrator was facing the victim. The wound was documented photographically with precise measurements for comparison with the seized weapon.',
            ],
            [
                'name' => 'Mass Food Poisoning Incident',
                'description' => 'Forensic examination was requested for a poisoning case affecting several family members after a shared dinner. Stomach contents and blood samples were collected for chemical analysis to detect toxic substances or pathogenic bacteria, with focus on ruling out intentional poisoning.',
            ],
            [
                'name' => 'Death by Firearm Injury',
                'description' => 'Examination of a victim who sustained a gunshot wound to the head. The firing distance was determined based on gunpowder residue around the entry wound, and the projectile trajectory inside the skull was traced. The bullet was extracted and preserved as physical evidence for matching with the suspected weapon.',
            ],
            [
                'name' => 'Time of Death Determination',
                'description' => 'A request from the public prosecution to determine the approximate time frame of death based on body temperature, degree of rigor mortis, and distribution of livor mortis. Ambient and body temperature readings were taken at the crime scene to calculate the heat loss rate.',
            ],
            [
                'name' => 'Suspected Asphyxiation Death',
                'description' => 'Examination of a female body found inside a closed room, with petechial hemorrhages in the eye conjunctiva and facial swelling, suggesting asphyxiation. The neck was carefully examined to rule out hanging or manual strangulation, and tissue samples were collected for microscopic analysis.',
            ],
            [
                'name' => 'DNA Analysis for Identity Confirmation',
                'description' => 'Unidentified human remains were found in a remote area. Bone marrow and dental samples were extracted to obtain DNA, matched against a missing persons database and potential relatives to help confirm identity.',
            ],
            [
                'name' => 'Fatal Traffic Accident',
                'description' => 'Examination of a driver who died in a collision on the ring road. Multiple fractures in the skull and limbs were documented, and a blood sample was taken to analyze alcohol and drug levels at the time of the accident, in addition to inspecting the seatbelt and airbags.',
            ],
            [
                'name' => 'Suspected Drug Overdose',
                'description' => 'Examination of a sudden death case involving an elderly patient on chronic medication. Blood and urine samples were collected to analyze drug levels, ruling out accidental or intentional overdose, alongside a review of the medical record and prescriptions.',
            ],
            [
                'name' => 'Fully Charred Body Case',
                'description' => 'A completely charred body was found inside a building affected by fire. Careful examination was required to determine whether death occurred before or as a result of the fire, by detecting carbon monoxide in the blood as evidence of smoke inhalation while alive.',
            ],
            [
                'name' => 'Suspected Medical Negligence',
                'description' => 'A family reported suspected medical negligence during a surgical procedure that resulted in death. The complete medical report and autopsy findings were reviewed to determine the direct cause of death and its relation to any procedural error during or after the operation.',
            ],
            [
                'name' => 'Fall From Height Case',
                'description' => 'Examination of a person who fell from the seventh floor of a residential building. The pattern of bone fractures and internal organ injuries was analyzed to determine body position during the fall, and whether it was accidental, suicidal, or the result of an assault.',
            ],
            [
                'name' => 'Weapon Identification from Wound Patterns',
                'description' => 'Several blunt-force injuries on a victim were examined and compared against multiple weapons seized at the crime scene. The shape and size of the injuries were matched to the edges of the seized tools to determine the most likely weapon used in the assault.',
            ],
            [
                'name' => 'Death in Custody Case',
                'description' => 'An official request to examine a body found deceased inside a detention facility to independently and impartially determine the cause of death. Any external bruises or injuries were documented and cross-referenced with the detainee\'s medical record before and during detention.',
            ],
            [
                'name' => 'Bloodstain Pattern Analysis',
                'description' => 'Analysis of bloodstain patterns at a murder scene to determine the angle and height of the bleeding source, and to attempt to reconstruct the sequence of events leading to death based on the direction and size of the stains.',
            ],
            [
                'name' => 'Suspected Newborn Death',
                'description' => 'Examination of a newborn body to verify whether it was born alive or stillborn, using the lung float test (docimasia pulmonum) and examination of organ maturity, to determine potential criminal liability in the case of death.',
            ],
            [
                'name' => 'Chemical Burn Injury Case',
                'description' => 'Examination of a victim exposed to a corrosive chemical substance. Burn depth and distribution were documented, with samples taken from affected tissue to identify the specific chemical agent involved and assess whether exposure was accidental or intentional.',
            ],
            [
                'name' => 'Suspected Domestic Violence Fatality',
                'description' => 'Examination of a body showing multiple injuries of different ages, suggesting a pattern of repeated abuse over time. Old and recent bruising was documented and correlated with any prior medical or police records related to the victim.',
            ],
            [
                'name' => 'Electrocution Death Case',
                'description' => 'Examination of a body found near exposed electrical wiring. Entry and exit burn marks were identified and documented, along with an assessment of cardiac tissue for signs consistent with electrical current passage, to confirm electrocution as the cause of death.',
            ],
            [
                'name' => 'Suspected Poisoning by Heavy Metals',
                'description' => 'A chronic illness case with unclear cause prompted forensic toxicology testing for heavy metal poisoning. Hair, nail, and blood samples were analyzed to detect long-term exposure patterns and determine whether the exposure was environmental, occupational, or intentional.',
            ],
        ];

        $users = DB::table('users')->pluck('id');

        foreach ($users as $userId) {
            $count = rand(10, 15);
            $selected = collect($caseTemplates)->shuffle()->take($count)->values();

            // Distribute this doctor's cases across the past 7 days (their own week),
            // cycling through the 7 days so multiple cases can land on the same day.
            $weekStart = Carbon::now()->startOfDay()->subDays(6);

            foreach ($selected as $index => $case) {
                $dayOffset = $index % 7;
                $createdAt = $weekStart->copy()
                    ->addDays($dayOffset)
                    ->addHours(rand(8, 20))
                    ->addMinutes(rand(0, 59));

                DB::table('use_cases')->insert([
                    'name' => $case['name'],
                    'description' => $case['description'],
                    'user_id' => $userId,
                    'status' => rand(0, 100) < 65 ? 'complete' : 'active',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt->copy()->addHours(rand(0, 48)),
                ]);
            }
        }
    }
}
