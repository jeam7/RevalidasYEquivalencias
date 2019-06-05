<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'careers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'school_id'];
    // protected $hidden = [];
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
    public function school(){
        return $this->belongsTo('App\Models\School');
    }

    public function subject(){
        return $this->hasMany('App\Models\Subject');
    }

    public function request_origin(){
      return $this->hasMany('App\Models\Request');
    }

    public function request_destination(){
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
    public function getCareerSchoolAttribute($value) {
      $foreignValue = ($this->school->faculty->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
       return $this->name.' - '.$this->school->name.'-'.$this->school->faculty->name.' - '.$this->school->faculty->college->name.' - '.$foreignValue;
    }

    public function getCollegeAttribute($value) {
       return $this->school->faculty->college->name;
    }

    public function getCollegeFacultyAttribute($value) {
       return $this->school->faculty->college->name .' - '. $this->name;
    }

    public function getCareerFacultyCollegeAttribute($value) {
      $foreignValue = ($this->school->faculty->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
       return $this->name.' - '.$this->school->faculty->name.' - '.$this->school->faculty->college->name.' - '.$foreignValue;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
