<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';

    public $incrementing = false;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function users () {
        return $this->hasMany('App\User', 'user_role_id');
    }
}
