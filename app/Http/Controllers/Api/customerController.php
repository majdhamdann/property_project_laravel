<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Token;
use Laravel\Passport\RefreshToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Customer;

class customerController extends Controller
{
      //register  ->post http://127.0.0.1:8000/api/customer/register
    public function registercustomer(Request $request){
        //validation
        $request->validate([
            "first_name"=>"required",
            "middle_name"=>"required",
            "last_name"=>"required",
            "email"=>"required|email|unique:customers",
            "password"=>"required",
            "phon_num"=>"required",
         ]);
        //creat data and save and response
        $customer=new Customer();
        $customer->first_name=$request->first_name;
        $customer->middle_name=$request->middle_name;
        $customer->last_name=$request->last_name;
        $customer->email=$request->email;
        $customer->password=bcrypt($request->password);
        $customer->phon_num=$request->phon_num;
        $customer->save();
         return response()->json([
            "status"=>1,
            "messege"=>"customer register successfully"

         ]);

    }
    //login ->post http://127.0.0.1:8000/api/customer/login
    public function logincustomer(Request $request){
        $customer= $request->validate([
            "email"=>"required",
            "password"=>"required"
         ]);
        
         if(auth()->guard('customer')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'customer']);
            
            $customer = Customer::select('customers.*')->find(auth()->guard('customer')->user()->id);
            $success =  $customer;
            $success['token'] =  $customer->createToken('ASDFGHJ',['customer'])->accessToken; 

            return response()->json([
                "status"=>1,
                "messege"=>"customer logined successfully",
                "success"=>$success
             ]); 
        }else{ 
            return response()->json([
                "status"=>0,
                "messege"=>"Email and Password are Wrong"
            ], 200);
        }
    }
    //logout ->get   http://127.0.0.1:8000/api/customer/logout
    public function logoutcustomer(Request $request){
      if ($request->user()) { 
        $request->user()->tokens()->delete();
        return response()->json([
            'message'  => 'customer Logout successfully',], 200);
       }
       return response()->json([
           'message'  => 'not successfully',], 200);

    }
    //profile->get    http://127.0.0.1:8000/api/customer/profile
    public function profile(){
          $customer=auth()->user();
          return response()->json([
            "status"=>1,
            "data"=>$customer
          ]);

    }


}
