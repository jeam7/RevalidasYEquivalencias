<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VoucherRequest as StoreRequest;
use App\Http\Requests\VoucherRequest as UpdateRequest;
use Illuminate\Support\Facades\DB;
use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;

/**
 * Class VoucherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class VoucherCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Voucher');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/voucher');
        $this->crud->setEntityNameStrings('Comprobante', 'Comprobantes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->setEditView('editVoucher');

        $this->crud->addFields([
            ['name' => 'request_id', // the db column for the foreign key
              'label' => "Numero de solicitud",
              'type' => 'select2',
              'entity' => 'request', // the method that defines the relationship in your Model
              'attribute' => 'data_request', // foreign key attribute that is shown to user
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                if (backpack_user()->type_user == 3) {
                  return $query->join('careers', 'careers.id', '=', 'requests.career_destination_id')
                                      ->join('schools', 'schools.id', '=', 'careers.school_id')
                                      ->where('schools.faculty_id', '=', backpack_user()->faculty_id)
                                      ->orderBy('requests.id', 'ASC')
                                      ->get();
                }else {
                  return $query->orderBy('id', 'ASC')->get();
                }
              })
            ]
        ], 'create');

        $this->crud->addFields([
            ['name' => 'request_id', // the db column for the foreign key
              'label' => "Numero de solicitud",
              'type' => 'select2',
              'entity' => 'request', // the method that defines the relationship in your Model
              'attribute' => 'data_request', // foreign key attribute that is shown to user
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              }),
              'attributes' => ['disabled' => 'disabled']
            ],
            ['name' => 'observations', 'label' => 'Observaciones', 'type'=>'textarea'],
            ['name' => 'date_subcomi_eq', 'label' => 'Fecha subcomision de equivalencias', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],
            ['name' => 'date_comi_eq', 'label' => 'Fecha comision de equivalencias', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],

            ['name' => 'date_con_fac', 'label' => 'Fecha consejo de facultad', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],

            ['name' => 'date_con_univ', 'label' => 'Fecha consejo universitario', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ]
        ], 'update');

        $this->crud->setColumns([
            ['name' => 'id', 'label' => 'Numero comprobante', 'type'=>'number'],
            ['name' => 'request_id', // the db column for the foreign key
              'label' => "Numero de solicitud",
              'type' => 'select',
              'entity' => 'request', // the method that defines the relationship in your Model
              'attribute' => 'id', // foreign key attribute that is shown to user
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'date_subcomi_eq', 'label' => 'Fecha subcomision de equivalencias', 'type'=>'date'],
            ['name' => 'date_comi_eq', 'label' => 'Fecha comision de equivalencias', 'type'=>'date'],
            ['name' => 'date_con_fac', 'label' => 'Fecha consejo de facultad', 'type'=>'date'],
            ['name' => 'date_con_univ', 'label' => 'Fecha consejo universitario', 'type'=>'date']
        ]);

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in VoucherRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function getSubjectsOrigin($id){
      $originSubjects = DB::select('SELECT s.id subjectId, s.name subjectName
                                    FROM vouchers v
                                    JOIN requests r ON (r.id = v.id)
                                    JOIN careers co ON (co.id = r.career_origin_id)
                                    JOIN subjects s ON (s.career_id = co.id)
                                    WHERE v.id = ?', [$id]);
      return $originSubjects;
    }

    public function getSubjectsDestination($id){
      $originSubjects = DB::select('SELECT s.id subjectId, s.name subjectName
                                    FROM vouchers v
                                    JOIN requests r ON (r.id = v.id)
                                    JOIN careers co ON (co.id = r.career_destination_id)
                                    JOIN subjects s ON (s.career_id = co.id)
                                    WHERE v.id = ?
                                      AND s.id NOT IN (SELECT subject_a_id from equivalent_subjects WHERE voucher_id = ?)', [$id, $id]);
      return $originSubjects;
    }

    public function createEquivalentSubject(Request $request)
    {
      $size = sizeof($request->values['equivalentsSubjects']);
      for ($i=0; $i < $size; $i++) {
        $insertEquivalentSubjects = DB::insert('INSERT INTO equivalent_subjects VALUES (?,?,?,?,NOW(),NOW())'
                                    ,[NULL, (int)$request->voucher_id, (int)$request->values['approvedSubject'], (int)$request->values['equivalentsSubjects'][$i]]);
      }

      return response()->json(['code_error' => 0 ]);
    }

    public function getEquivalentSubject($id){
      $skip = DB::select('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"');
      $equivalents = DB::select('SELECT es.id id, es.voucher_id voucherId, s.id subjectId, s.name subjectName, s.credits subjectsCredits,
			                           group_concat(s2.id SEPARATOR ",") subjectEquivalentId, group_concat(s2.name SEPARATOR ",") subjectEquivalentName
                                 FROM equivalent_subjects es
                                 JOIN subjects s ON (s.id = es.subject_a_id)
                                 JOIN subjects s2 ON (s2.id = es.subject_e_id)
                                 WHERE es.voucher_id = ?
                                 GROUP BY es.subject_a_id', [$id]);
      return $equivalents;
    }

    public function deleteEquivalentSubject(Request $request){
      $voucherId = (int)$request->record["voucherId"];
      $equivalentId = (int)$request->record["subjectId"];

      $deleted = DB::delete('DELETE
                            FROM equivalent_subjects
                            WHERE voucher_id = ? AND subject_a_id = ?', [$voucherId, $equivalentId]);
      return $deleted;
    }
}
