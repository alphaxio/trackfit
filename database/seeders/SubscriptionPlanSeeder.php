<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
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
                'name' => 'monthly plan',
                'description' => 'Payment per month',
                'discount' => 0,
                'price' => '5000',
                'duration' => 30,
            ],
            [
                'name' => 'yearly plan',
                'description' => 'Payment per year',
                'discount' => 16,
                'price' => '3200',
                'duration' => 365,
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create([
                'name' => $plan['name'],
                'description' => $plan['description'],
                'discount' => $plan['discount'],
                'price' => $plan['price'],
                'duration' => $plan['duration'],
            ]);
        }
    }
}
