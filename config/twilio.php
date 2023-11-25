<?php

return [
    'enable' => env('ENABLE_TWILIO', false),
    'account_sid' => env('TWILIO_SID', ''),
    'auth_token' => env('TWILIO_TOKEN', ''),
    'number' => env('TWILIO_NUMBER', ''),
];
