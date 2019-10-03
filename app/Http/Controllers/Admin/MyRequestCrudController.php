<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\MyRequestRequest as StoreRequest;
use App\Http\Requests\RequestRequestUpdate as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\DB;
use App\Models\Request;
use App\Models\Subject;
use App\Models\Career;
use App\Models\School;
use App\Models\Faculty;
use App\Models\College;
use Carbon\Carbon;
/**
 * Class RequestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MyRequestCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\MyRequest');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/myrequest');
        $this->crud->setEntityNameStrings('Solicitudes', 'Mis Solicitudes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->addClause('where', 'user_id', '=', backpack_user()->id);
        $this->crud->denyAccess(['update','delete']);

        $this->crud->addFields([
          [
              'name' => 'college_id',
              'label' => "Universidad procedencia",
              'type' => 'select2_from_array',
              'options' => College::all()->pluck('name', 'id'),
              'allows_null' => false,
              'default' => ''
          ],
          //
          [
              'name' => 'career_origin_id',
              'label' => "Carrera procedencia",
              'type' => 'select2_from_ajax_custom',
              'data_source' => url("/admin/api/careerOrigin"),
              'placeholder' => '',
              'minimum_input_length' => 0,
              'method' => 'POST',
              'dependencies' => ['college_id'],
              'model' => 'App\Models\Career',
              'default' => '',
              'attribute' => 'name',
              'entity' => 'career_origin'
          ],
          //
          [
              'name' => 'college_destination_id',
              'label' => "Universidad destino",
              'type' => 'select2_from_array',
              'options' => College::all()->pluck('name', 'id'),
              'allows_null' => false,
              'default' => ''
          ],
          //
          [
              'name' => 'career_destination_id',
              'label' => "Carrera Destino",
              'type' => 'select2_from_ajax_custom',
              'data_source' => url("/admin/api/careerDestination"),
              'placeholder' => '',
              'minimum_input_length' => 0,
              'method' => 'POST',
              'dependencies' => ['college_destination_id'],
              'model' => 'App\Models\Career',
              'default' => '',
              'attribute' => 'name',
              'entity' => 'career_destination'
          ],
          //
          [
            // n-n relationship
            'label' => "End", // Table column heading
            'type' => "select2_from_ajax_multiple",
            'name' => 'id', // the column that contains the ID of that connected entity
            'entity' => 'subject', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Subject", // foreign key model
            'data_source' => url("/admin/api/subjectOrigin"), // url to controller search function (with /{id} should return model)
            'placeholder' => "Select a city", // placeholder for the select
            'minimum_input_length' => 2, // minimum characters to type before querying results
            // 'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
          ]
        ], 'create');

        $this->crud->setColumns([
          ['name'=>'id', 'type' => 'text', 'label' => 'Numero de solicitud'],
          //
          ['name' => 'created_at', 'label' => 'Fecha', 'type' => 'date'],
          //
          ['name' => 'college_career_origin',
            'label' => 'Carrera origen',
            'type' => 'text',
            'limit'=>70,
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career_origin', function ($q) use ($column, $searchTerm) {
                    $q->where('careers.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name' => 'college_career_destination',
            'label' => 'Carrera destino',
            'type' => 'text',
            'limit'=>70,
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career_destination', function ($q) use ($column, $searchTerm) {
                    $q->where('careers.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'last_status', 'type' => 'text_custom', 'label' => 'Estatus actual']
        ]);

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
    }

    public function store(StoreRequest $request)
    {
        $today = Carbon::now();
        $origin = Career::find($request->request->get('career_origin_id'));
        $request->request->set('origin', $origin->school->faculty->college->foreign);
        $request->request->set('user_id', backpack_user()->id);
        $request->request->set('date', $today);
        $redirect_location = parent::storeCrud($request);
        $lastRequestId = Request::orderBy('created_at', 'desc')->first();
        $lastRequestId = $lastRequestId->id;
        $insertStatus = DB::insert('INSERT INTO request_has_status VALUES (?, ?, ?, ?, ?)', [NULL, $lastRequestId, 1, $today, NULL]);
        return $redirect_location;
    }
}
