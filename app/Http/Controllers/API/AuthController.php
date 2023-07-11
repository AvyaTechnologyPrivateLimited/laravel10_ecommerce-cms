<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Auth;
use Illuminate\Validation\Rules\Password;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        if (!auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized', 'message'=>'Credentials are invalid, please check email or password.'], 401);
        }
        
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token, $user, 'Logged in successfully');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            //'password' => 'required|string|confirmed|min:6',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'via' => 'API'
        ]);

        $token = JWTAuth::fromUser($user);
        
        return $this->respondWithToken($token, $user, 'Your account has been created successfully.');

    }

    public function getaccount()
    {
        if(Auth::check()) {
            return response()->json(auth()->user());
        } else {
            return response()->json(['error' => true, 'message' => 'usr not logged in']);
        }
    }

    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users,email,'.Auth::id(),
            'phone' => 'required|max:10',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = User::find(Auth::id());

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->via = 'api';

        if($user->save()) {
            return response()->json(['error' => false, 'data' => $user, 'message' => 'Profile is saved successfully']);
        } else {
            return response()->json(['error' => true,  'message' => 'Profile is not saved successfully']);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current' => ['required'],
            'new' => ['required'],
            'confirm' => ['required', 'same:new'],
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }


        if(!Hash::check($request->get('current'), Auth::user()->password)) {
            return response()->json(['error' => true,  'message' => 'Current Password is not matched']);
        }

        $save = User::find(auth()->user()->id)->update(['password'=> Hash::make($request->get('new'))]);

        if($save) {
            return response()->json(['error' => false, 'message' => 'Password is changed successfully']);
        } else {
            return response()->json(['error' => true, 'message' => 'Password is not saved successfully']);
        }
   
    }



    /*public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }*/
    protected function respondWithToken($token, $user, $msg)
    {
        return response()->json([
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'message' => $msg,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 //mention the guard name inside the auth fn
        ]);
    }
}
