<?php

namespace App\Providers;

use App\Services\ScheduleService;
use App\Contracts\ScheduleContract;
use App\Services\SocialUserResolver;
use App\Services\ExerciseDayService;
use App\Services\DailyScheduleService;
use App\Contracts\ExerciseDayContract;
use Illuminate\Support\ServiceProvider;
use App\Contracts\DailyScheduleContract;
use App\Services\ExerciseProgressService;
use App\Contracts\ExerciseProgressContract;
use App\Contracts\SettingContract;
use App\Contracts\SubscriptionContract;
use App\Services\SettingService;
use App\Services\SubscriptionService;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
        ScheduleContract::class            => ScheduleService::class,
        DailyScheduleContract::class       => DailyScheduleService::class,
        ExerciseDayContract::class         => ExerciseDayService::class,
        ExerciseProgressContract::class    => ExerciseProgressService::class,
        SubscriptionContract::class        => SubscriptionService::class,
        SettingContract::class             => SettingService::class,
    ];


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(SocialUserResolverInterface::class, SocialUserResolver::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
