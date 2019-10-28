<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class Subject extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subjects';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'info', 'credits', 'career_id', 'code'];
    // protected $hidden = [];
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['equivalent_subject_a', 'equivalent_subject_e'];

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
    public function career(){
        return $this->belongsTo('App\Models\Career');
    }

    // public function equivalent_subject_(){
    //     return $this->hasMany('App\Models\Equivalent_subject');
    // }

    public function equivalent_subject_a(){
        return $this->hasMany('App\Models\Equivalent_subject', 'subject_a_id');
    }

    public function equivalent_subject_e(){
        return $this->hasMany('App\Models\Equivalent_subject', 'subject_e_id');
    }

    public function request()
    {
        return $this->belongsToMany('App\Models\Request','requests_subjects', 'request_id', 'subject_id')->withPivot('created_at', 'updated_at');
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
    public function getSubjectFacultyAttribute($value) {
       return $this->name . ' - ' . $this->career->name;
    }

    public function getCollegeNameAttribute($value) {
      $foreignValue = ($this->career->school->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
      return $this->career->school->college->name . ' - ' . $foreignValue;
    }

    public function getFacultyNameAttribute($value) {
      return $this->career->school->faculty ? $this->career->school->faculty->name : 'No aplica';
    }

    public function getSchoolNameAttribute($value) {
       return $this->career->school->name;
    }

    public function getCareerNameAttribute($value) {
       return $this->career->name;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
