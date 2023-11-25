<?php

namespace Database\Seeders;

use App\Models\DynamicContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DynamicContent::create([
            'type' => DynamicContent::$TERMS,
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium error ipsum recusandae reiciendis asperiores repellat provident ipsam quaerat dolor voluptatibus?'
        ]);

        DynamicContent::create([
            'type' => DynamicContent::$FAQ,
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium'
        ]);

        DynamicContent::create([
            'type' => DynamicContent::$FAQ,
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium'
        ]);

        DynamicContent::create([
            'type' => DynamicContent::$FAQ,
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium'
        ]);

        DynamicContent::create([
            'type' => DynamicContent::$POLICY,
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Praesentium Praesentium error ipsum recusandae reiciendis asperiores repellat provident ipsam quaerat dolor voluptatibus?'
        ]);


        DynamicContent::create([
            'type' => DynamicContent::$CONTACT,
            'title' => 'Phone Number',
            'content' => '+68847383746783'
        ]);


        DynamicContent::create([
            'type' => DynamicContent::$CONTACT,
            'title' => 'Email Address',
            'content' => 'trackfit@gmail.com'
        ]);

    }
}
