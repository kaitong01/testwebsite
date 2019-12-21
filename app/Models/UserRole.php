<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $table = 'users_roles';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillable = [
        'name', 'description'
    ];

    public function user(){
        return $this->hasMany('App\User');
    }

    // public function permissions() {
    //     return $this->belongsToMany("App\Permission");
    // }
}
