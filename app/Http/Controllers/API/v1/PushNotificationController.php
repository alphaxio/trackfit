<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Exception;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function sendCustomNotification(Request $request){
        $this->validate($request,[
            'user_id'   => 'required',
            'title'     => 'nullable',
            'message'   => 'nullable'
        ]);

        $totalSent = 0;
        $failedSent = [];

        foreach($request->user_id as $user_id){
            try{
                $user = User::find($user_id);

                if($user){
                    $user->notify(new SendPushNotification($request));

                    $totalSent++;
                }
            }catch(Exception $e){
                $failedSent[] = [
                    'user_id' => $user_id,
                    'message' => $e->getMessage(),
                ];
            }
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Successfully Send {$totalSent} Push Notification",
            'errors' => $failedSent,
        ]);
    }

    public function sendNotificationByType(Request $request, $type){
        $this->validate($request,[
            'user_id'   => 'required',
        ]);

        $totalSent = 0;
        $failedSent = [];

        $notifications = [
            'PN0001' => [
                'notification_type' => 'PN0001',
                'title' => 'Training Day Alert',
                'message' => "Don't forget to rest up, you have a training session tomorrow!",
            ],
            'PN0002' => [
                'notification_type' => 'PN0002',
                'title' => 'Training Day Alert',
                'message' => "Your training session is today! Give it your best shot!",
            ],
        ];

        if(!isset($notifications[$type])){
            return response()->json([
                'code' => 400,
                'status' => 'failed',
                'message' => "Successfully Send {$totalSent} Push Notification. This Feature for Testing Only",
                'errors' => $failedSent,
            ]);
        }else{
            foreach($request->user_id as $user_id){
                try{

                    $user = User::find($user_id);

                    if($user){
                        $user->notify(new SendPushNotification((object) $notifications[$type]));
                        $totalSent++;
                    }
                }catch(Exception $e){
                    $failedSent[] = [
                        'user_id' => $user_id,
                        'message' => $e->getMessage(),
                    ];
                }
            }
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Successfully Send {$totalSent} Push Notification. This Feature for Testing Only",
            'errors' => $failedSent,
        ]);
    }
}
