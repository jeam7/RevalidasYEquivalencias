<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class Request extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;
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
      'user_id','career_origin_id','career_destination_id', 'origin', 'date',
      'others','info_others','pensum','notes','study_programs','title','copy_ci',
      'ci_passport_copy','notes_legalized','study_program_legalized','cerification_category_college','certification_title_no_confered','translation'
      ];
    protected $hidden = ['origin', 'user_id', 'info_others'];
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['voucher'];

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
      return $this->hasMany('App\Models\Voucher');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeRequestByFaculty($query, $typeUser) {
      $query->select('requests.*')->join('careers', 'careers.id', '=', 'requests.career_destination_id')
                        ->join('schools', 'schools.id', '=', 'careers.school_id')
                        ->where('schools.faculty_id', '=', $typeUser);
      return $query;
    }
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
      return $this->id . ' - '
            . $this->user->ci  . ' - '
            . $this->user->first_name . ' '
            . $this->user->last_name . ' - '
            . ($this->career_origin ? $this->career_origin->name : 'Sin carrera origen') . ' - '
            . ($this->career_destination ? $this->career_destination->name : 'Sin carrera destino');
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
