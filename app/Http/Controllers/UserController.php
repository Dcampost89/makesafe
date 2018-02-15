<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['signin', 'signup']]);
    }

    public function signin(Request $request) {
        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $errs = $validator->errors();
            $errors = [];
            foreach ($errs->all() as $message){
                array_push($errors, $message);
            }
            return $this->error('Something was wrong', $errors, 401);
        }

        $user = User::with('userRole')->where('account', $request->input('account'))->first();

        if (!$user) {
            return $this->error('User with those credentials was not found', [], 404);
        } 

        if (!Hash::check($request->password, $user->password)) {
            return $this->error('Wrong password', [], 404);
        }

        $token = Auth::attempt($request->only(['account', 'password']));
        $user->api_token = $token;
        $user->save();
        
        return $this->success('Successfully signed in', ['user' => $user, 'token' => $token], 200);
    }

    public function signup (Request $request) {
        $validator = Validator::make($request->all(), [
            'account' => 'required|unique:users',
            'password' => 'required',
            'user_role_id' => 'required|integer',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'provider' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            $errs = $validator->errors();
            $errors = [];
            foreach ($errs->all() as $message) {
                array_push($errors, $message);
            }
            return $this->error('something was wrong', $errors, 401);
        }
        
        $user = new User;
        $user->user_role_id = $request->input('user_role_id');
        $user->account = $request->input('account');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->has('email') ? $request->input('email') : '';
        $user->phone = $request->has('phone') ? $request->input('phone') : '';
        $user->provider = $request->input('provider');
        $user->save();

        $token = Auth::attempt($request->only(['account', 'password']));
        $user->api_token = $token;
        $user->save();
        $user->userRole();
        
        return $this->success('Successfully signed up', ['user' => $user, 'token' => $token], 200);
    }

    public function signoff() {
        Auth::logout();
        return $this->success('Successfully signed off', [], 200);
    }

    public function currentUser() {
        $user = Auth::user();
        return $this->success('Current user foun', $user, 200);
    }
}

