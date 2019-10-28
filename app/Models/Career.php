<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class Career extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;
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
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['subject'];
    protected $appends = ['college_name'];

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
    public function scopeCareersByFaculty($query, $facultyId){
        return $query->join('schools', 'schools.id', '=', 'careers.school_id')
                      ->join('faculties', 'faculties.id', '=', 'schools.faculty_id')
                      ->where('faculties.id', '=', $facultyId);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    // public function getCareerSchoolAttribute($value) {
    //   $foreignValue = ($this->school->faculty->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
    //    return $this->name.' - '.$this->school->name.'-'.$this->school->faculty->name.' - '.$this->school->faculty->college->name.' - '.$foreignValue;
    // }
    //
    // public function getCollegeAttribute($value) {
    //    return $this->school->faculty->college->name;
    // }
    //
    public function getCollegeCareerRequestAttribute($value) {
       return $this->school->college->name . ' - ' . $this->name;
    }
    //
    // public function getCareerFacultyCollegeAttribute($value) {
    //   $foreignValue = ($this->school->faculty->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
    //    return $this->name.' - '.$this->school->faculty->name.' - '.$this->school->faculty->college->name.' - '.$foreignValue;
    // }

    // public function getTestTestAttribute($value) {
    //    return $this->name;
    // }

    public function getCollegeNameAttribute($value) {
       $foreignValue = ($this->school->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
       return $this->school->college->name . ' - ' . $foreignValue;
    }

    public function getFacultyNameAttribute($value) {
       return $this->school->faculty ? $this->school->faculty->name : 'No aplica';
    }

    public function getSchoolNameAttribute($value) {
       return $this->school->name;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
