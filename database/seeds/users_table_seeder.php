<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class users_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hasher = app()->make('hash'); 

        $user = new User();
        $user->user_role_id = 10;
        $user->email = 'daniel@email.com';
        $user->phone = '13125009841';
        $user->account = 'daniel@email.com';
        $user->password = $hasher->make('secret');
        $user->provider = 'email';
        $user->is_verified = false;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();
    }
}
