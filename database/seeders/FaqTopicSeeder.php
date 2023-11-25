<?php

namespace Database\Seeders;

use App\Models\FaqTopic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqTopic::Create([
            'topic' => "Topic 1"
        ]);

        FaqTopic::Create([
            'topic' => "Topic 2"
        ]);

        FaqTopic::Create([
            'topic' => "Topic 3"
        ]);

        FaqTopic::Create([
            'topic' => "Topic 4"
        ]);
    }
}
