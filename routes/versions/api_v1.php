<?php

use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\CalenderController;
use App\Http\Controllers\API\v1\ExerciseController;
use App\Http\Controllers\API\v1\FCMTokenController;
use App\Http\Controllers\API\v1\ProgressController;
use App\Http\Controllers\API\v1\PushNotificationController;
use App\Http\Controllers\API\v1\RecordController;
use App\Http\Controllers\API\v1\ReportController;
use App\Http\Controllers\API\v1\ScheduleController;
use App\Http\Controllers\API\v1\SettingController;
use App\Http\Controllers\API\v1\SettingsController;
use App\Http\Controllers\API\v1\SubscriptionController;
use App\Http\Controllers\API\v1\TranslationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $array = [
        'status' => true,
        'message' => 'Hello there!...',
        'data' => [
            'service' => 'fitness-api',
            'version' => '1.0',
        ],
    ];
    return response()->json($array);
});


// Route::group(['middleware' => ['cors', 'json.response']], function () {
Route::group(['middleware' => ['json.response']], function () {
    //get  before auth,
    Route::get('/body/parts', [ProgressController::class, 'getBodyParts'])->name('get.BodyParts');
    Route::get('/muscle/groups', [ProgressController::class, 'getMuscleGroups'])->name('get.MuscleGroups');
    Route::get('/muscle/groups/{id}/body/part', [ProgressController::class, 'getMuscleGroupsBodyPart'])->name('get.MuscleGroupsBodyPart');
    Route::get('/muscle/group/body/parts', [ProgressController::class, 'muscleGroupBodyParts'])->name('get.mgbp');

    //inquiries
    Route::get('/inquiries', [SettingsController::class, 'inquiries'])->name('get.inquiries');

    //Dynamic Content
    Route::get('/faqs', [SettingController::class, 'faqs'])->name('get.faqs');
    Route::get('/term-of-use', [SettingController::class, 'terms'])->name('get.terms');
    Route::get('/contacts', [SettingController::class, 'contacts'])->name('get.contacts');
    Route::get('/privacy-policy', [SettingController::class, 'policies'])->name('get.policy');


    //Auth
    // Route::post('register', [AuthController::class, 'register'])->name('register');
    // Route::post('login', [AuthController::class, 'login'])->name('login');
    // Route::post('/forgot/password', [AuthController::class, 'sendResetPasswordToken'])->name('forgot.password');
    // Route::post('/reset/password', [AuthController::class, 'resetPassword'])->name('reset.password');
    //save email


    Route::post('/authorization', [AuthController::class, 'authorization'])->name('authorization');
    Route::post('google/authorization', [AuthController::class, 'googleAuthorization'])->name('google.authorization');



    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('/email', [AuthController::class, 'email'])->name('email');
        Route::post('/phone', [AuthController::class, 'phone'])->name('phone');
        Route::get('/user/profile', [AuthController::class, 'profile']);
        Route::post('/verify/phone', [AuthController::class, 'verifyPhone'])->name('verify.phone');
        Route::post('/resend/otp', [AuthController::class, 'resendOTP'])->middleware('throttle:1,1');
        // Route::post('/resend/otp', [AuthController::class, 'resendOTP'])->middleware('throttle:otp');

        Route::group(['prefix' => 'exercises', 'as' => 'exercises'], function () {
            Route::get('/types', [ExerciseController::class, 'types'])->name('exercises.type');
        });

        Route::group(['middleware' => ['verify.phone']], function () {
            Route::post('/create/pt/schedule', [ScheduleController::class, 'createPTSchedule'])->name('create.PTSchedule');
            Route::post('/create/pe/schedule', [ScheduleController::class, 'createPESchedule'])->name('create.PESchedule');

            // Route::group(['middleware' => ['check.schedule']], function () {

            Route::get('/my/schedules', [ScheduleController::class, 'mySchedules'])->name('my.schedule');
            Route::get('/active/schedule', [ScheduleController::class, 'activeSchedule'])->name('active.schedule');
            Route::get('/schedule/statistics/{id}', [ScheduleController::class, 'statSchedule'])->name('stat.schedule');
            Route::get('/active/schedule/statistics', [ScheduleController::class, 'activeStatSchedule'])->name('active.stat.schedule');

            Route::group(['middleware' => ['active.schedule']], function () {
               Route::put('/schedule/{id}/update', [ScheduleController::class, 'updateSchedule'])->name('update.schedule');
                Route::post('/schedule/{id}/end', [ScheduleController::class, 'endSchedule'])->name('end.schedule');
            });
            // Route::get('/active/schedule/{id}', [ScheduleController::class, 'statScehdule'])->name('active.stat.schedule');


            Route::group(['prefix' => 'progresses', 'as' => 'progresses'], function () {
                Route::get('/', [ProgressController::class, 'progresses'])->name('progresses');
            });

            //progress
            Route::get('/schedules/progress', [ProgressController::class, 'getAllScheduleProgress'])->name('getProgress.list');
            Route::get('/schedules/{id}/progress/{date}/{type?}', [ProgressController::class, 'getScheduleProgress'])->name('getExercise.status');
            Route::patch('/schedules/{id}/progress/{date}', [ProgressController::class, 'updateProgress']);
            Route::patch('/schedules/{id?}/progress/{date?}/update', [ProgressController::class, 'updateProgress'])->name('update.progress');
            Route::post('/schedules/{id?}/progress/{date?}/media', [ProgressController::class, 'uploadMedia']);

            Route::group(['prefix' => 'schedules', 'as' => 'schedules'], function () {
                Route::get('/', [ProgressController::class, 'schedules'])->name('schedules');
                Route::get('/{id}/exercise/days', [ProgressController::class, 'getExerciseDays'])->name('get.ExerciseDays');
            });



            //calender days
            Route::get('/calender/active', [CalenderController::class, 'activeCalender'])->name('getActive.schedule');
            Route::get('/calender/{schedule}', [CalenderController::class, 'calenderSchedule'])->name('getCalender.schedule');
            Route::get('/regular/days/{schedule}', [CalenderController::class, 'regularDays'])->name('regular.days');
            Route::put('/add/regular/days/schedule/{schedule}', [CalenderController::class, 'updateRegularDaysSchedule'])->name('update.regularDays');

            //records
            Route::get('/schedule/records', [RecordController::class, 'getRecordList'])->name('get.Records');
            Route::get('/schedule/records/{id}', [RecordController::class, 'showRecord'])->name('show.RecordById');

            // Report
            Route::get('/reports/{schedule_id}', [ReportController::class, 'getReportList'])->name('get.Reports');


            // Subscription Feature
            Route::get('/subscription/info', [SubscriptionController::class, 'getSubcriptionInfo'])->name('get.SubcriptionInfo');
            Route::post('/subscriptions', [SubscriptionController::class, 'subscription'])->name('post.subscription');

            //Payment
            Route::post('/payments/callback', [SubscriptionController::class, 'payment'])->name('post.payments');

            //Settings
            Route::get('/inquiries', [SettingController::class, 'inquiry'])->name('get.inquiries');
            Route::get('/tickets', [SettingController::class, 'ticketList'])->name('get.tickets');
            Route::get('/tickets/{id}', [SettingController::class, 'ticket'])->name('get.ticket');
            Route::post('/tickets/submit', [SettingController::class, 'submitTicket'])->name('post.tickets');
            Route::post('/tickets/{id}/comment', [SettingController::class, 'ticketComment'])->name('post.tickets.comment');

            Route::post('/delete/account', [SettingController::class, 'deleteAccount'])->name('delete.account');

            Route::delete('/account', [SettingController::class, 'deleteAccount'])->name('account.delete');

            // Translations
            Route::get('/translation/sync', [TranslationController::class, 'sync']);
            // });

            // Notification
            Route::post('/notifications/push', [PushNotificationController::class, 'sendCustomNotification']);
            Route::post('/notifications/push/{type}', [PushNotificationController::class, 'sendNotificationByType']);
            Route::post('/user/fcm_token', [FCMTokenController::class, 'store']);

        });
    });

    // Route::group(['middleware' => ['api']], function () {
    //     // your routes here'
    //     Route::get('google', [AuthController::class, 'socialLogin']);
    // });

});

Route::fallback(function () {
    $array = [
        'status' => true,
        'message' => 'Oops! You probably hit the wrong endpoint, anyways...',
        'data' => [
            'service' => 'fitness-api',
            'version' => '1.0',
        ],
    ];
    return response()->json($array);
});
