<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use Log, JWTAuth;

class UserHelper
{
    public static function getUserFromJwtToken(Request $request)
    {
        $token = $request->bearerToken();
        
        if($token && $token!=='undefined')
        {
            try {
                return JWTAuth::setToken($token)->toUser();
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                //exception
                //Log::error($e);
            }
        }
    }
}