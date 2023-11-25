<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transtaltion = [
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'Progress',
                'value' => '운동 스케줄',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'progress report',
                'value' => '경과 보고서',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'record',
                'value' => '기록',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'You can record your diet meals every day. After exercise, record your body photo.',
                'value' => '식단을 매일 기록할 수 있어요. 운동이 끝난 직후에는 눈바디도 함께 기록해보세요.',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'Easy to check your exercise part in calendar. It is also easy to know that you missed or passed a PT.',
                'value' => '달력에서 운동한 부위를 쉽게 확인할 수 있어요. 운동을 못한 날에는 빠진건지, 미룬건지 알 수 있어요.',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'Ai will support you to better exercising. Check it regularly while doing exercise.',
                'value' => '회원님의 상태를 분석하고, 개선 방안을 제공해요. 그 외에도 다양한 정보를 함께 제공 합니다.',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'When you record anything in ‘Progress’, you can easy to access quickly all dates though ‘Record’.',
                'value' => '운동 스케줄에서 기록한 모든 기록들은 언제든 ‘기록’을 통해서 한 눈에 확인할 수 있어요.',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'monthly plan',
                'value' => '월간 플랜',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'yearly plan',
                'value' => '연간 플랜',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'Payment per month',
                'value' => '1개월마다 결제',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'Payment per year',
                'value' => '1년마다 결제',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'Easy to check your exercise part in calendar. It is also easy to know that you missed or passed a PT.',
                'value' => '달력에서 운동한 부위를 쉽게 확인할 수 있어요. 운동을 못한 날에는 빠진건지, 미룬건지 알 수 있어요.',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'Ai will support you to better exercising. Check it regularly while doing exercise.',
                'value' => '회원님의 상태를 분석하고, 개선 방안을 제공해요. 그 외에도 다양한 정보를 함께 제공 합니다.',
            ],
            [
                'locale' => 'ko',
                'type' => 'subscriptions',
                'key' => 'When you record anything in ‘Progress’, you can easy to access quickly all dates though ‘Record’.',
                'value' => '운동 스케줄에서 기록한 모든 기록들은 언제든 ‘기록’을 통해서 한 눈에 확인할 수 있어요.',
            ],
            [
                'locale' => 'ko',
                'type' => 'inquiries',
                'key' => 'Fitness Routine.',
                'value' => '피트니스 루틴.',
            ],
            [
                'locale' => 'ko',
                'type' => 'inquiries',
                'key' => 'Need Help on Gym plans.',
                'value' => '체육관 계획에 대한 도움이 필요합니다.',
            ],
            [
                'locale' => 'ko',
                'type' => 'inquiries',
                'key' => 'I need personal Trainer.',
                'value' => '개인 트레이너가 필요합니다.',
            ],
        ];

        foreach($transtaltion as $transtaltion){
            Translation::create($transtaltion);
        }
    }
}
