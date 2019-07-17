<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class User extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;
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
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['request'];

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
    public function scopeMyFaculty($query, $typeUser) {
        $query = $query->where(function($query){
          $query->where('type_user', '=', 4);
        })->orWhere(function($query) use($typeUser){
          $query->where('type_user', '=', 3)
                ->where('faculty_id', '=', $typeUser);
        });
        return $query;
    }
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
