<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class Voucher extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'vouchers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['id', 'request_id', 'observations', 'date_subcomi_eq', 'date_comi_eq', 'date_con_fac', 'date_con_univ'];
    // protected $hidden = [];
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['equivalent_subject'];
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
    public function request(){
      return $this->belongsTo('App\Models\Request');
    }
    public function equivalent_subject(){
      return $this->hasMany('App\Models\Equivalent_subject');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeVoucherByFaculty($query, $facultyId) {
      $query->select('vouchers.*')->join('requests', 'requests.id', '=', 'vouchers.request_id')
                        ->join('careers', 'careers.id', '=', 'requests.career_destination_id')
                        ->join('schools', 'schools.id', '=', 'careers.school_id')
                        ->where('schools.faculty_id', '=', $facultyId);
      return $query;
    }
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getCareerOriginAttribute($value)
    {
      return $this->request->career_origin_id;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
