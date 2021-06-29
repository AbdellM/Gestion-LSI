<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|between:2,100',
            'prenom' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'dateN' => 'required|string|min:10',
            'role' => 'required|string|between:2,100',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
    
        $user = User::create(array_merge(
                    $validator->validated()
                ));
    
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    
    
    
    
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    
    
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Either email or password is wrong.'], 401);
        }
        return $this->createNewToken($token);
    }
    
    
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully logged out']);
    }
    
    
    public function userProfile() {
        if(auth()->user()->role == "admin")
            return AdminController::userProfile(auth()->user()->id);
        else if(auth()->user()->role == "student")
            return StudentController::userProfile(auth()->user()->id);
        if(auth()->user()->role == "prof")
            return ProfController::userProfile(auth()->user()->id);
    }
}
