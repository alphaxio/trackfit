<?php

namespace App\Http\Controllers\API\v1\Auth;

use Laravel\Passport\Token;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    use ApiResponses;

    private function getToken($user)
    {
        Passport::personalAccessTokensExpireIn(now()->addDays(30));
        return $user->createToken('Personal Access Token');
    }

    private function randomToken($default=false){
        if($default){
            return 1234;
        }

        $random_token  = rand(1000, 9000);
        $random_token_exists = User::query()
            ->where('password_reset_token', $random_token)
            ->orWhere('otp', $random_token)
            ->exists();

            if ($random_token_exists) {
            return $this->randomToken();
        }

        return $random_token;
    }

    public function client()
    {
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));

        return $client;
    }

    private function slug(): \Ramsey\Uuid\UuidInterface
    {
        $slug = Str::uuid();
        $slug_exists = User::query()
            ->where('slug', $slug)
            ->exists();
        if ($slug_exists) {
            return $this->slug();
        }
        return $slug;
    }

    protected function sendOTP($phone_number, $otp) {
        if(config('twilio.enable', false) && $phone_number != '+6287777788888'){
            $twilio_number = config('twilio.number', '');
            $account_sid = config('twilio.account_sid', '');
            $auth_token = config('twilio.auth_token', '');

            $message = '본인확인 인증번호는 '.  $otp  . ' 입니다';
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($phone_number, [
                'from' => $twilio_number,
                'body' => $message]);
        }
    }

    public function isTestEnvironment($phone_number){
        if(config('app.env') == 'production' && $phone_number != '+6287777788888'){
            return false;
        }

        return true;
    }


    /**
     * Authorization a user as a user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function authorization(Request $request): JsonResponse
    {
        $this->validate($request, [
            'phone_number' => ['bail', 'required', 'string', 'min:10'],
        ]);

        try{
            $message = "";

            $otp = $this->randomToken($this->isTestEnvironment($request->phone_number));

            $user = User::where('phone_number', $request->phone_number)->first();

            if($user){
                $user->phone_verified_at = null;
                $user->otp = $otp;
                $user->save();

            } else {
                $user = User::create([
                    'slug' => $this->slug(),
                    'phone_number' => $request->phone_number,
                    'otp' => $otp,
                ]);

                // Assign Role
                $role = Role::where('name', 'USER')->firstorFail();
                $user->assignRole($role);

                Auth::login($user);

                $message = 'Registration Successful, An OTP has been sent to your phone number';
                // Log::info($otp);
            }

            $user->refresh();

            // Send OTP Using Twilio if Enabled
            if($user->phone_number != '+6287777788888'){
                $this->sendOTP($user->phone_number, $otp);
            }

            $user_data = new UserResource($user);
            $token = $this->getToken($user);

            return $this->okayApiResponse([
                'message' => $message,
                'user' => $user_data,
                'token' => $token,
            ]);
        }catch (\Exception $exception){
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }

    public function googleAuthorization(Request $request)
    {
        try{
            $this->validate($request, [
                'id_token' => ['bail', 'nullable', 'string', 'min:10'],
                'email' => ['bail', 'required', 'email'],
                'sub' => ['bail', 'required', 'string'],
                'given_name' => ['bail', 'required', 'string'],
                'family_name' => ['bail', 'required', 'string'],
                'email_verified' => ['bail', 'nullable'],
            ]);

            // $validation = Validator::make($request->all(), [
            //     'id_token' => ['bail', 'nullable', 'string', 'min:10'],
            //     'email' => ['bail', 'required', 'email'],
            //     'sub' => ['bail', 'required', 'string'],
            //     'given_name' => ['bail', 'required', 'string'],
            //     'family_name' => ['bail', 'required', 'string'],
            //     'email_verified' => ['bail', 'required', 'string'],
            // ]);

            // $attribute = $validation->validated();
            // $client = new \Google_Client();
            // $client->setClientId(env('GOOGLE_CLIENT_ID'));
            // $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            // // $client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));

            // dd(env('GOOGLE_CLIENT_ID'), env('GOOGLE_CLIENT_SECRET'), env('GOOGLE_REDIRECT_URL'));
            // Specify the CLIENT_ID of the app that accesses the backend
            // $CLIENT_ID = "334712771111-qhd81a76oinrqonq0et6rfgk0sgf1ndp.apps.googleusercontent.com";

            // $CLIENT_ID="282541068657-bt7du17rh8ovgpmi7u4m9iehnt7iggtm.apps.googleusercontent.com";
            // $client = new \Google_Client(['client_id' => $CLIENT_ID]);

            // $auth = $client->verifyIdToken($attribute['id_token']);

            // if (! $auth) {
            //     return $this->errorApiResponse("User Not Found", 404);
            // }

            $log_user  = User::where("email", $request["email"])->where("sub", null)->first();

            if($log_user)
            {
                return $this->errorApiResponse("Please sign in using your phone number or sign in with google with another email address",
                        406
                );
            }

            $auth_user  = User::where("email", $request["email"])->where("sub", $request["sub"])->first();

            if($auth_user) {
                 // Check if user is deleted
                 if($auth_user->trashed()) {
                    return $this->errorApiResponse("Your Account Was Deleted", 400);
                }

                $token = $auth_user->createToken('Laravel Password Grant Client')->accessToken;
                $user_data = $auth_user;
                $token = $this->getToken($auth_user);
                return $this->okayApiResponse([
                    'user' => $user_data,
                    'token' => $token,
                ]);
            } else {

                $slug = $this->slug();
                $user = new User();
                $user->slug = $slug;
                $user->sub = $request["sub"];
                $user->first_name = $request["given_name"];
                $user->last_name = $request["family_name"];
                $user->email = $request["email"];
                $user->provider_name = "google";
                $user->email_verified_at = $request["email_verified"] ? Carbon::now() : null;
                $user->save();

                // Assign Role
                $role = Role::where('name', 'USER')->firstorFail();
                $user->assignRole($role);
                Auth::login($user);

                $user_data = $user;
                $token = $this->getToken($user);
                $message = 'Registration Successful, Kindly Input your phone number to be verified';

                return $this->okayApiResponse([
                    'message' => $message,
                    'user' => $user_data,
                    'token' => $token,
                ]);
            }

            }catch (\Exception $exception){
                return $this->errorApiResponse($exception->getMessage(), 400);
            };
    }

    public function phone(Request $request)
    {
        try{
            $validation = Validator::make($request->all(), [
                'phone_number' => ['bail', 'required', 'string', 'min:10', 'unique:users'],
            ]);

            if ($validation->fails()) {
                $message = $validation->messages()->first();
                return $this->errorApiResponse($message, 400);
            }

            $user = auth()->user();
            if(! $user)
            {
                return $this->errorApiResponse('user does not exist', 404);
            }
            $attribute = $validation->validated();

            $otp = $this->randomToken($this->isTestEnvironment($request->phone_number));

            // Send OTP Using Twilio if Enabled
            $this->sendOTP($user->phone_number, $otp);


            //save user email
            $user->phone_number = $attribute['phone_number'];
            $user->otp = $otp;
            $user->save();

            $user_data = new UserResource($user);
            $message = 'Please verify your phone with the OTP sent';
            return $this->okayApiResponse([
                'message' => $message,
                'user' => $user_data,
            ]);
        }catch (\Exception $exception){
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }


    public function verifyPhone(Request $request)
    {
        $this->validate($request, [
            'otp' => ['bail', 'required', 'integer', 'min:4'],
        ]);

        try{
            $user = Auth::user();

            if(! $user){
                return $this->errorApiResponse('user does not exist', 404);
            }

            if(! $user->phone_number){
                return $this->errorApiResponse('Please input a phone number to verify', 400);
            }

            if($user->otp  != $request->otp){
                // return $this->errorApiResponse('Invalid OTP', 404);
                return $this->errorApiResponse('인증번호가 맞지 않습니다.', 404);
            }

            // Logout from other device by revoking all user token except the current
            Token::where('user_id', $user->id)
                ->where('id', '<>', $user->token()->id) // Exclude the current user's token
                ->delete();

            $user->otp = null;
            $user->phone_verified_at = Carbon::now();
            $user->is_first_login = false;
            $user->save();

            return $this->successNoDataApiResponse(
                'Phone number verified successfully'
            );
        }catch (\Exception $exception){
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }


    public function email(Request $request)
    {
        try{
            $validation = Validator::make($request->all(), [
                'email' => ['bail', 'required', 'string', 'min:10', 'unique:users'],
            ]);
            if ($validation->fails()) {
                $message = $validation->messages()->first();
                return $this->errorApiResponse($message, 400);
            }

            $user = auth()->user();
            if(! $user)
            {
                return $this->errorApiResponse('user does not exist', 404);
            }
            $attribute = $validation->validated();
            //save user email
            $user->email = $attribute['email'];
            $user->save();
            $user_data = new UserResource($user);
            $message = 'Email saved successfully';
            return $this->okayApiResponse([
                'message' => $message,
                'user' => $user_data,
            ]);
        }catch (\Exception $exception){
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }

    public function resendOTP()
    {
        try{
            $user = auth()->user();
            $otp = $this->randomToken($this->isTestEnvironment($user->phone_number));

            //save otp
            $user->otp = $otp;
            $user->save();

            // Send OTP Using Twilio if Enabled
            $this->sendOTP($user->phone_number, $otp);

            return $this->successNoDataApiResponse('OTP resent successfully', 200);
        }catch (\Exception $exception){
            return $this->errorApiResponse($exception->getMessage(), 400);
        };

    }

    public function profile(){
        $user = Auth::user();

        return $this->okayApiResponse([
            'message' => 'Success Retrieve Profile',
            'user' => new UserResource($user),
        ]);
    }

    public function logout()
    {
        $user = auth()->user()->token();
        $user->revoke();

        return $this->successNoDataApiResponse('You are logged out');
    }
}
