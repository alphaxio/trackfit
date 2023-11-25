<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            ExerciseTypeSeeder::class,
            MuscleGroupSeeder::class,
            BodyPartSeeder::class,
            SuperAdminSeeder::class,
            UserTypeSeeder::class,
            SubscriptionPlanSeeder::class,
            SubscriptionFeatureSeeder::class,
            InquirySeeder::class,
            DynamicContentSeeder::class,
            FaqTopicSeeder::class,
            FaqQuerySeeder::class,
        ]);
    }
}
