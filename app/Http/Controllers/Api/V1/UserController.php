<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


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
  
  public function login()
  {
    
  }
  //----------
  
  public function logout()
  {
    
  }
  //----------
  
}
