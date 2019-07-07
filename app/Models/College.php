<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
class College extends Model
{
    use CrudTrait;
    use SoftDeletes, CascadeSoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'colleges';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'foreign', 'address', 'abbreviation'];
    // protected $hidden = [];
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['faculty'];

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
        return $this->hasMany('App\Models\Faculty');
    }

    // public static function boot()
    // {
    //     parent::boot();
    //
    //     // cause a delete of a product to cascade to children so they are also deleted
    //     static::deleting(function($college)
    //     {
    //         $college->faculty()->delete();
    //     });
    // }
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
    public function getNameForeignAttribute($value) {
      $foreignValue = ($this->foreign == 1) ? 'Nacional' : 'Extranjera' ;
       return $this->name.' - '.$foreignValue;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
