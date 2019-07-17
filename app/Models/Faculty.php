<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class Faculty extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'faculties';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'college_id'];
    // protected $hidden = [];
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['user', 'school', 'academic_period'];
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
    public function user(){
        return $this->hasMany('App\Models\User');
    }

    public function college(){
        return $this->belongsTo('App\Models\College');
    }

    public function school(){
        return $this->hasMany('App\Models\School');
    }

    public function academic_period(){
        return $this->hasMany('App\Models\Academic_period');
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
    public function getFacultyCollegeAttribute($value) {
      $foreignValue = ($this->college->foreign == 1 ) ? 'Nacional' : 'Extranjera' ;
      return $this->name . ' - ' . $this->college->name . ' - ' . $foreignValue;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
