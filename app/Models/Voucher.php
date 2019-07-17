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
      $query->select('vouchers.*')->join('requests as r', 'r.id', '=', 'vouchers.request_id')
                                  ->join('careers', 'careers.id', '=', 'r.career_destination_id')
                                  ->join('schools', 'schools.id', '=', 'careers.school_id')
                                  ->where('schools.faculty_id', '=', $facultyId);
      // $query->select('vouchers.id', 'vouchers.request_id', 'vouchers.observations', 'vouchers.date_subcomi_eq', 'vouchers.date_comi_eq', 'vouchers.date_con_fac', 'vouchers.date_con_univ',
      //                   'vouchers.deleted_at', 'vouchers.created_at', 'vouchers.updated_at')
      //                   ->join('requests as r', 'r.id', '=', 'vouchers.request_id')
      //                   ->join('careers', 'careers.id', '=', 'r.career_destination_id')
      //                   ->join('schools', 'schools.id', '=', 'careers.school_id')
      //                   ->where('schools.faculty_id', '=', $facultyId);
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

    public function getUserCiAttribute($value)
    {
      return $this->request->user->ci;
    }

    public function getCareerOriginTableAttribute($value)
    {
      return ($this->request->career_origin ? $this->request->career_origin->school->faculty->college->name : '') . ' - '
      . ($this->request->career_origin ? $this->request->career_origin->name : '');
    }

    public function getCareerDestinationTableAttribute($value)
    {
      return ($this->request->career_destination ? $this->request->career_destination->school->faculty->college->name : '') . ' - '
      . ($this->request->career_destination ? $this->request->career_destination->name : '');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
