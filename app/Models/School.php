<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class School extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'schools';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'faculty_id', 'college_id'];
    // protected $hidden = [];
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['career'];

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

    public function college(){
        return $this->belongsTo('App\Models\College');
    }

    public function career(){
        return $this->hasMany('App\Models\Career');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    // public function scopeSchoolByFaculty($query, $typeUser) {
    //   $query->select('')->join('careers', 'careers.id', '=', 'requests.career_destination_id')
    //                     ->join('schools', 'schools.id', '=', 'careers.school_id')
    //                     ->where('schools.faculty_id', '=', $typeUser);
    //   return $query;
    // }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getSchoolFacultyAttribute($value) {
      if ($this->faculty == null) {
        $foreignValue = ($this->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
        return $this->name.' - '.'No aplica'.' - '.$this->college->name.' - '.$foreignValue;
      }else {
        $foreignValue = ($this->faculty->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
         return $this->name.' - '.$this->faculty->name.' - '.$this->faculty->college->name.' - '.$foreignValue;
      }
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
