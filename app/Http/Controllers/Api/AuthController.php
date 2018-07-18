<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 
	public $loginAfterSignUp = true;

    
    public function register(Request $request){

    	$this->validate($request, [
            'username'  => 'required|string',
            'password'  => 'required|string|min:3|max:15',
            'email'     => 'required|email|unique:users'
        ]);

        // $user = new User();
        // $user->username = $request->username;
        // $user->password = bcrypt($request->password);
        // $user->email = $request->email;
        // $user->save();

        $user = User::create([
            'username'  => $request->username,
            'password'  => bcrypt($request->password),
            'email'     => $request->email
        ]);

        if ($this->loginAfterSignUp)
            return $this->login($request);
        

        return response()->json([
            'success' => true,
            'result' => $user
        ], 200);
    }

    public function login(Request $request){
        
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'result' => 'Invalid Email or Password',
            ]);
        }
        JWTAuth::setToken($jwt_token);
        $user = JWTAuth::toUser();    
        return response()->json([
            'success' => true,
            'result' => ['token' => $jwt_token , 'user' =>$user ],
        ]);
    }

    public function logout(Request $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'result' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'result' => 'Sorry, the user cannot be logged out'
            ]);
        }
    }

    public function getAuthUser(Request $request){
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json([
            'success' => true,
            'result' => $user
            ]);
    }


}
