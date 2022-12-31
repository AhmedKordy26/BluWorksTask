<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $req_fields = $request->validate([
            'user_name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string',
            'phone_number'=>'required|string',
            'birthday'=>'required|date',

        ]);

        $user=User::create([
            'user_name'=>$req_fields['user_name'],
            'email'=>$req_fields['email'],
            'password'=>bcrypt($req_fields['password']),
            'phone_number'=>$req_fields['phone_number'],
            'birthday'=>$req_fields['birthday']
        ]);

        $token = $user->createToken('authenticationToken')->plainTextToken;

        $req_response=[
            'user'=>$user,
            'token'=>$token
        ];
        
        return response($req_response,201);
    }

    public function login(Request $request){
        $req_fields = $request->validate([
            'user_name'=>'required|string',
            'password'=> 'required|string'
        ]);

        // check if user exists  with given user name
        $user = User::where('user_name',$req_fields['user_name'])->first();
        if(!$user){
            return response(['message'=>"user name doesn't exists"],401);
        }

        // the user exists => check for password
        if(!Hash::check($req_fields['password'], $user->password)){
            return response(['message'=>"wrong password"],401);
        }
        

        // if we get here then credentials are ok
        $token = $user->createToken('authenticationToken')->plainTextToken;

        $req_response=[
            'user'=>$user,
            'token'=>$token
        ];
        
        return response($req_response,200);

    }

    public function getAllUsers(){
        return User::all();
    }

    public function getUser($id){
        $user=User::find($id);
        if($user)
            return $user;
        else
            return response(['message'=>"user id doesn't exist"],404);
    }

    public function deleteUser($id){
        return User::destroy($id);
    }

    
    public function updateUser(Request $request,$id){
        $user=User::find($id);
        if($user){
            $user->update($request->all());
            return $user;
        }
        else{
            return response(['message'=>"user id doesn't exist"],404);
        }
    }
}
