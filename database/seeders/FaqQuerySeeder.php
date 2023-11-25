<?php

namespace Database\Seeders;

use App\Models\FaqQuery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqQuerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqQuery::Create([
            'faq_topic_id' => 1,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);

        FaqQuery::Create([
            'faq_topic_id' => 1,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);

        FaqQuery::Create([
            'faq_topic_id' => 2,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);

        FaqQuery::Create([
            'faq_topic_id' => 2,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);

        FaqQuery::Create([
            'faq_topic_id' => 3,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);

        FaqQuery::Create([
            'faq_topic_id' => 3,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);


        FaqQuery::Create([
            'faq_topic_id' => 4,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);


        FaqQuery::Create([
            'faq_topic_id' => 4,
            'question' => 'Lorem ipsum dolor sit amet.',
            'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum rem architecto omnis veniam libero. Vitae?'
        ]);
    }
}
