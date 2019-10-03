<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class MyRequest extends Model
{
    use CrudTrait;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'requests';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
      'user_id','career_origin_id','career_destination_id', 'origin',
      'others','info_others','pensum','notes','study_programs','title','copy_ci',
      'ci_passport_copy','notes_legalized','study_program_legalized','cerification_category_college','certification_title_no_confered','translation', 'date'
      ];
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
    public function career_origin(){
      return $this->belongsTo('App\Models\Career');
    }

    public function career_destination(){
      return $this->belongsTo('App\Models\Career');
    }

    public function user(){
      return $this->belongsTo('App\Models\User');
    }

    public function voucher(){
      return $this->belongsTo('App\Models\Voucher');
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
    public function getLastStatusAttribute($value)
    {
      $lastStatus = DB::select('SELECT rhs.request_status_id request_status_id, rs.name name
                                FROM request_has_status rhs
                                JOIN request_status rs ON (rs.id = rhs.request_status_id)
                                WHERE request_id = ? ORDER BY rhs.id DESC LIMIT 1',
                                [$this->id]);
      return $lastStatus[0]->name;
    }

    public function getDataRequestAttribute($value)
    {
      return $this->id . ' - ' . $this->user->ci  . ' - ' . $this->user->first_name . ' ' . $this->user->last_name . ' - ' . $this->career_origin->name . ' - ' . $this->career_destination->name;
    }

    public function getCollegeCareerOriginAttribute($value)
    {
      return $this->career_origin->school->college->name . ' - ' . $this->career_origin->name;
    }

    public function getCollegeCareerDestinationAttribute($value)
    {
      return $this->career_destination->school->college->name . ' - ' . $this->career_destination->name;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
