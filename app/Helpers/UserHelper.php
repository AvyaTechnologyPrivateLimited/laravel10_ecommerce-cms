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
                $user = JWTAuth::setToken($token)->toUser();
                return $user;
            } catch (\Exception $e) {
                //exception
                //Log::error($e);
            }
        }
    }
}