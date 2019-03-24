<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\MyRequestRequest as StoreRequest;
use App\Http\Requests\RequestRequestUpdate as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\DB;
use App\Models\Request;
use App\Models\Career;
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
            // ['name' => 'user_id', // the db column for the foreign key
            //   'label' => "Cedula solicitante",
            //   'type' => 'select2',
            //   'entity' => 'user', // the method that defines the relationship in your Model
            //   'attribute' => 'user_fullname', // foreign key attribute that is shown to user
            //   'model' => "App\Models\User",
            //   'options'   => (function ($query) {
            //     return $query->where('type_user','=', 4)->orderBy('id', 'ASC')->get();
            //   })
            // ],
            ['name' => 'career_origin_id', // the db column for the foreign key
              'label' => "Carrera - Facultad - Universidad de procedencia",
              'type' => 'select2',
              'entity' => 'career_origin', // the method that defines the relationship in your Model
              'attribute' => 'career_school', // foreign key attribute that is shown to user
              'model' => "App\Models\Career",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'career_destination_id', // the db column for the foreign key
              'label' => "Carrera - Facultad - Universidad donde desea cursar",
              'type' => 'select2',
              'entity' => 'career_destination', // the method that defines the relationship in your Model
              'attribute' => 'career_school', // foreign key attribute that is shown to user
              'model' => "App\Models\Career",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ]
        ], 'create');


        // $this->crud->addFields([
        //   ['name' => 'user_id', // the db column for the foreign key
        //     'label' => "Cedula solicitante",
        //     'type' => 'select2',
        //     'entity' => 'user', // the method that defines the relationship in your Model
        //     'attribute' => 'user_fullname', // foreign key attribute that is shown to user
        //     'model' => "App\Models\User",
        //     'options'   => (function ($query) {
        //       return $query->where('type_user','=', 4)->orderBy('id', 'ASC')->get();
        //     }),
        //     'attributes' => ['disabled' => 'disabled']
        //   ],
        //   ['name' => 'career_origin_id', // the db column for the foreign key
        //     'label' => "Carrera - Facultad - Universidad de procedencia",
        //     'type' => 'select2',
        //     'entity' => 'career_origin', // the method that defines the relationship in your Model
        //     'attribute' => 'career_school', // foreign key attribute that is shown to user
        //     'model' => "App\Models\Career",
        //     'options'   => (function ($query) {
        //       return $query->orderBy('id', 'ASC')->get();
        //     }),
        //     'attributes' => ['disabled' => 'disabled']
        //   ],
        //   ['name' => 'career_destination_id', // the db column for the foreign key
        //     'label' => "Carrera - Facultad - Universidad donde desea cursar",
        //     'type' => 'select2',
        //     'entity' => 'career_destination', // the method that defines the relationship in your Model
        //     'attribute' => 'career_school', // foreign key attribute that is shown to user
        //     'model' => "App\Models\Career",
        //     'options'   => (function ($query) {
        //       return $query->orderBy('id', 'ASC')->get();
        //     }),
        //     'attributes' => ['disabled' => 'disabled']
        //   ],
        //   [
        //     'label' => 'Procedencia de su universidad',
        //     'name' => 'origin',
        //     'type' => 'toggle_only_read',
        //     'inline' => true,
        //     'options' => [
        //       1 => 'Nacional',
        //       2 => 'Extranjera'
        //     ],
        //     'hide_when' => [
        //       1 => ['ci_passport_copy', 'notes_legalized', 'study_program_legalized', 'cerification_category_college', 'certification_title_no_confered', 'translation'],
        //       2 => ['others', 'info_others', 'pensum', 'notes', 'study_programs', 'title', 'copy_ci']
        //     ],
        //     'default' => \Route::current()->parameter('origin'),
        //     'attributes' => ['disabled' => 'disabled']
        //   ],
        //   ['name' => 'others', 'label' => 'Otros documentos entregados', 'type' => 'checkbox'],
        //   ['name' => 'info_others', 'label' => 'Descripcion de otros documentos entregados', 'type' => 'textarea'],
        //   ['name' => 'pensum', 'label' => 'Pensum', 'type' => 'checkbox'],
        //   ['name' => 'notes', 'label' => 'Certificacion de notas (original)', 'type' => 'checkbox'],
        //   ['name' => 'study_programs', 'label' => 'Programas de estudios (autenticados)', 'type' => 'checkbox'],
        //   ['name' => 'title', 'label' => 'Si es egresado universitario, copia del titulo', 'type' => 'checkbox'],
        //   ['name' => 'copy_ci', 'label' => 'Fotocopia de la cedula de identidad', 'type' => 'checkbox'],
        //   ['name' => 'ci_passport_copy', 'label' => 'Cedula de identidad o pasaporte (fotocopia)', 'type' => 'checkbox'],
        //   ['name' => 'notes_legalized', 'label' => 'Certificacion de notas, legalizadas por las autoridades competentes (original y copia)', 'type' => 'checkbox'],
        //   ['name' => 'study_program_legalized', 'label' => 'Programas de estudios (originales, legalizados)', 'type' => 'checkbox'],
        //   ['name' => 'cerification_category_college', 'label' => 'Certificacion de la categoria universitaria del instituto de procedencia (oficialmente reconocida por las autoridades del pais de origen)', 'type' => 'checkbox'],
        //   ['name' => 'certification_title_no_confered', 'label' => 'Certificacion en donde conste que no le ha sido conferido el titulo correspondiente (En caso de haber aprobado todos los anos de estudio sin obtener el titulo)', 'type' => 'checkbox'],
        //   ['name' => 'translation', 'label' => 'Traduccion al castellano por interprete publico autorizado, en caso de estar la documentacion en idioma extranjero (original y fotocopia)', 'type' => 'checkbox'],
        //   ['name'=>'last_status', 'type' => 'text_custom', 'label' => 'Estatus actual'],
        //   [ 'name' => 'estatus',
        //     'label' => "Estatus",
        //     'type' => 'select_from_array',
        //     'options' => [
        //       2 => 'Devuelta por falta de documentos',
        //       3 => 'Enviada a la comision de revalidas y equivalencias',
        //       4 => 'Enviada de la subcomision de revalidas y equivalencias',
        //       5 => 'Enviada al consejo de facultad',
        //       6 => 'Recibida por la direccion de revalidas y equivalencias',
        //       7 => 'Enviada al consejo universitario',
        //       8 => 'Procesada'
        //     ],
        //     'default' => 2
        //   ]
        // ], 'update');

        $this->crud->setColumns([
          // ['name' => 'user_id', // the db column for the foreign key
          //   'label' => "Cedula solicitante",
          //   'type' => 'select',
          //   'entity' => 'user', // the method that defines the relationship in your Model
          //   'attribute' => 'ci', // foreign key attribute that is shown to user
          //   'model' => "App\Models\User",
          //   'options'   => (function ($query) {
          //     return $query->orderBy('ci', 'ASC')->get();
          //   }),
          //   "key" => "ci"
          // ],
          ['name'=>'id', 'type' => 'text', 'label' => 'Numero de solicitud'],
          // ['name' => 'user_id', // the db column for the foreign key
          //   'label' => "Nombre completo solicitante",
          //   'type' => 'select',
          //   'entity' => 'user', // the method that defines the relationship in your Model
          //   'attribute' => 'fullname', // foreign key attribute that is shown to user
          //   'model' => "App\Models\User",
          //   'options'   => (function ($query) {
          //     return $query->orderBy('ci', 'ASC')->get();
          //   }),
          //   "key" => "fullname"
          // ],
          ['name' => 'created_at', 'label' => 'Fecha', 'type' => 'datetime'],
          ['name' => 'career_origin_id', // the db column for the foreign key
            'label' => "Universidad procedencia",
            'type' => 'select',
            'entity' => 'career_origin', // the method that defines the relationship in your Model
            'attribute' => 'college_faculty', // foreign key attribute that is shown to user
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
          ['name' => 'career_destination_id', // the db column for the foreign key
            'label' => "Universidad destino",
            'type' => 'select',
            'entity' => 'career_destination', // the method that defines the relationship in your Model
            'attribute' => 'college_faculty', // foreign key attribute that is shown to user
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
          ['name'=>'last_status', 'type' => 'text_custom', 'label' => 'Estatus actual']
        ]);
        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in RequestRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        // $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // dd($request->request);
        // your additional operations before save here

          $origin = Career::find($request->request->get('career_origin_id'));
          $request->request->set('origin', $origin->school->faculty->college->foreign);
          $request->request->set('user_id', backpack_user()->id);
          // dd($request->request);
          $redirect_location = parent::storeCrud($request);

          $lastRequestId = Request::orderBy('created_at', 'desc')->first();
          $lastRequestId = $lastRequestId->id;
          $today = Carbon::now();
          $insertStatus = DB::insert('INSERT INTO request_has_status VALUES (?, ?, ?, ?, ?)', [NULL, $lastRequestId, 1, $today, NULL]);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here

        $othersInfo = ($request->request->get('others') == 1) ? $request->request->get('info_others') : "" ;
        $request->request->set('info_others', $othersInfo);
        $redirect_location = parent::updateCrud($request);
        $today = Carbon::now();
        $insertStatus = DB::insert('INSERT INTO request_has_status VALUES (?, ?, ?, ?, ?)', [NULL, $request->request->get('id'), $request->request->get('estatus'), $today, NULL]);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
