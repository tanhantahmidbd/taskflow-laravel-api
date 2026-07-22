<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    //

  public function success($data = [],$message = "success",$code = 200)
  {
    $data = [
      'status'=>true,
      'message'=>$message,
      'data' =>$data
    ];
    return response()->json($data,$code);
  }//-----
  public function error($data =[],$message="failed",$code=404)
  {
    $data = [
      'status'=>false,
      'message'=>$message,
      'data' =>$data
    ];
    return response()->json($data,$code);
  }
}
