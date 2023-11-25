<?php

namespace Database\Seeders;

use App\Models\SubcriptionFeature;
use App\Models\SubscriptionFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Progress',
                'description' => 'You can record your diet meals every day. After exercise, record your body photo.',
            ],
            [
                'name' => 'Calendar',
                'description' => 'Easy to check your exercise part in calendar. It is also easy to know that you missed or passed a PT.',
            ],
            [
                'name' => 'progress report',
                'description' => 'Ai will support you to better exercising. Check it regularly while doing exercise.'
            ],
            [
                'name' => 'record',
                'description' => "When you record anything in ‘Progress’, you can easy to access quickly all dates though ‘Record’."
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionFeature::create([
                'name' => $plan['name'],
                'description' => $plan['description'],
                'is_active' => true,
            ]);
        }
    }
}
