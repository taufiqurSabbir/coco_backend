<?php

namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegistationRequest;
use App\Http\Resources\User\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
   public function login(LoginRequest $request){

       $user = User::where('email', $request->email)->first();

       $auth_check = auth()->attempt([
           'email' => $request->email,
           'password' => $request->password,
       ]);
     if ($auth_check){
         $token =  $user->createToken('user-token')->plainTextToken;
//       return AuthResource::make($user);

         return (new AuthResource($user))
             ->additional(['data' => [
                 'token' => $token,
                 'token_type' => 'Bearer'
             ]]);
     }else{
         return response()->json([
             'message' => 'The provided credentials are incorrect.',
         ], 422);
     }


   }




   public function registation(RegistationRequest $request){

       $user = User::create([
           'name'=>$request->input('name'),
           'user_name'=>$request->input('user_name'),
           'phone'=>$request->input('phone'),
           'email'=>$request->input('email'),
           'role'=>$request->input('role'),
           'password'=>bcrypt($request->input('password')),
       ]);

       $token =  $user->createToken('user-token')->plainTextToken;

       return (new AuthResource($user))
           ->additional(['data' => [
               'token' => $token,
               'token_type' => 'Bearer'
           ]]);
   }

   public function email_varification(EmailVerificationRequest $request){
          $user= User::where('email',$request->email)->first()->email;
          $otp = rand(0, 99999);;


   }
}
