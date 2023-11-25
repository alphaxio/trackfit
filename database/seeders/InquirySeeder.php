<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inquiry::create([
            'name' => 'Fitness Routine',
        ]);

        Inquiry::create([
            'name' => 'Need Help on Gym plans',
        ]);


        Inquiry::create([
            'name' => 'I need personal Trainer',
        ]);

        Inquiry::create([
            'name' => 'Others',
        ]);
    }
}
