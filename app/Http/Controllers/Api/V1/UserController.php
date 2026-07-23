<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    //
  public function register(Request $request)
  {
    $checkValidator = Validator::make($request->all(),[
      'name'=>'required|string|min:3',
      'email'=>'required|email|unique:users,email',
      'password' => 'required|min:4|max:8|confirmed'                             
      ]);

    if($checkValidator->fails()){
      return $this->error($checkValidator->errors());
    }

    $input = $checkValidator->validated();
    $input['password'] = bcrypt($input['password']);
    
    $user = User::create($input);
    if($user){
      $token = $user->createToken("auth-token")->plainTextToken;
      $user['token'] = $token;
      return $this->success($user,"User Registration Successful",201);
    }
    return $this->error([],"Registration Failed",500);

    
  }
  //----------
  
  public function login(Request $request)
  {
    $checkValidator = Validator::make($request->all(),[
      'email' => 'required|email',
      'password'=> 'required|min:4|max:8'                                
    ]);

    if($checkValidator->fails()){
      return $this->error($checkValidator->errors());
    }

    if(!Auth::attempt($checkValidator->validated())){
      return $this->error([],"Invaild email or password");
    }

    $user = Auth::user();
    $user['token'] = $user->createToken("auth-token")->plainTextToken;
    return $this->success($user,"Login successful",200);
  }
  //----------
  
  public function logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();
    return $this->success([],"Logout Successful",200);
  }
  //----------
  
}
