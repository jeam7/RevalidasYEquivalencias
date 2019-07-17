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
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
