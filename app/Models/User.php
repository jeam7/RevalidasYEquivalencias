<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'users';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['ci', 'first_name', 'last_name', 'place_birth', 'nacionality', 'birthdate', 'gender', 'address', 'phone', 'type_user', 'faculty_id', 'email', 'password'];
    protected $hidden = ['password'];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function faculty(){
        return $this->belongsTo('App\Models\Faculty');
    }

    public function request(){
        return $this->hasMany('App\Models\Request');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getUserFullnameAttribute($value) {
       return $this->ci.' - '.$this->first_name.' '.$this->last_name;
    }

    public function getFullnameAttribute($value) {
       return $this->first_name.' '.$this->last_name;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
