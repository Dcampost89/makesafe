<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function signin(Request $request)
    {
        $errors = $this->validate($request);

        if (!empty($errors)) {
            return $this->error('Something was wrong', $errors, 401);
        }

        $user = User::where('account', $request->input('account'))->first();

        if (!$user) {
            return $this->error('User with those credentials was not found', [], 404);
        } 

        if (!Hash::check($request->password, $user->password)) {
            return $this->error('Wrong password', [], 404);
        }

        $token = Auth::attempt($request->only(['account', 'password']));
        
        return $this->success('Successfully signed in', ['user' => $user, 'token' => $token], 200);
    }

    public function signup (Request $request) {
        $errors = $this->validate($request);
        if ($errors) {
            return $this->error('something was wrong', $errors, 401);
        }
        $user = new User;
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->account = $request->input('account');
        $user->is_verified = $request->input('is_verified');
        $user->provider = $request->input('provider');
        $user->api_token = $request->input('api_token');
        $user->save();

        $token = Auth::attempt($request->only(['account', 'password']));
        
        return $this->success('Successfully signed up', ['user' => $user, 'token' => $token]);
    }

    public function signoff()
    {
        Auth::logout();
        return $this->success('Successfully signed off', [], 200);
    }

    private function validate (Request $request) {
        $errors = [];

        $validator = Validator::make($request->all(), [
            'account' => 'required|unique',
            'password' => 'required',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'is_verified' => 'nullable|boolean',
            'provider' => 'nullable|string',
            'api_token' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
        }

        return $errors;
    }
}

