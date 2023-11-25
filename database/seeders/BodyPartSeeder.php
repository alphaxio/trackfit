<?php

namespace Database\Seeders;

use App\Models\BodyPart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BodyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BodyPart::create([
            'muscle_group_id' => 1,
            'name' => '가슴', //'Chest',
        ]);

        BodyPart::create([
            'muscle_group_id' => 1,
            'name' => '등', //'Back',
        ]);

        BodyPart::create([
            'muscle_group_id' => 1,
            'name' =>  '하체', //'Lower Body',
        ]);

        BodyPart::create([
            'muscle_group_id' => 2,
            'name' => '팔', //'Arm',
        ]);

        BodyPart::create([
            'muscle_group_id' => 2,
            'name' => '어깨' //'Shoulder',
        ]);

        BodyPart::create([
            'muscle_group_id' => 2,
            'name' => '배' //'Abs',
        ]);
    }
}
