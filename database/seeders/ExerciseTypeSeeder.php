<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExerciseType;
class ExerciseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExerciseType::create([
            'name' => 'Personal Excercise',
            'code' => 'pe'
        ]);


        ExerciseType::create([
            'name' => 'Personal Trainer',
            'code' => 'pt'
        ]);
    }
}
