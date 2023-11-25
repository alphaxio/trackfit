<?php

namespace Database\Seeders;

use App\Models\MuscleGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuscleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MuscleGroup::create([
            'name' => 'Big Muscles',
            'muscle_code' => 'big_muscles',
            'description' => 'Description of big muscles',
        ]);

        MuscleGroup::create([
            'name' => 'Small Muscles',
            'muscle_code' => 'small_muscles',
            'description' => 'Description of small muscles',
        ]);
    }
}
