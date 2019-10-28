<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RequestRequest as StoreRequest;
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
use Barryvdh\DomPDF\Facade as PDF;
/**
 * Class RequestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class RequestCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Request');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/request');
        $this->crud->setEntityNameStrings('Solicitud', 'Solicitudes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addClause('RequestList');


        $this->crud->addButtonFromView('line', 'botonGenerarPdfSolicitud', 'botonGenerarPdfSolicitud', 'bottom');
        $this->crud->addButtonFromView('line', 'botonAnadirComprobante', 'botonAnadirComprobante', 'bottom');

        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update', 'show' ]);
            // $this->crud->addClause('requestByFaculty', backpack_user()->faculty_id);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list', 'update', 'show']);
            // $this->crud->addClause('requestByFaculty', backpack_user()->faculty_id);
            break;
          default:
            break;
        }

        $this->crud->addFields([
            ['name' => 'user_id',
              'label' => "Cédula solicitante",
              'type' => 'select2',
              'entity' => 'user',
              'attribute' => 'user_fullname',
              'model' => "App\Models\User",
              'options'   => (function ($query) {
                return $query->where('type_user','=', 4)->orderBy('id', 'ASC')->get();
              })
            ],
            //
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
              'label' => "Asignaturas equivalentes",
              'type' => "select2_from_ajax_multiple_custom",
              'name' => 'subject',
              'entity' => 'request',
              'attribute' => "name",
              'model' => "App\Models\Subject",
              'data_source' => url("/admin/api/subjectOrigin"),
              'placeholder' => "",
              'minimum_input_length' => 0,
              'pivot' => true,
              'dependencies' => ['college_id', 'career_origin_id'],
            ]
        ], 'create');


        $currentRequest = \Route::current()->parameter('request');
        $currentRequest = Request::find($currentRequest);
        $currentCollegeOrigin = $currentRequest ? $currentRequest->career_origin->school->college->id : NULL;
        $currentCollegeDestination = $currentRequest ? $currentRequest->career_destination->school->college->id : NULL;

        $this->crud->addFields([
          ['name' => 'user_id',
            'label' => "Cédula solicitante",
            'type' => 'select2',
            'entity' => 'user',
            'attribute' => 'user_fullname',
            'model' => "App\Models\User",
            'options'   => (function ($query) {
              return $query->where('type_user','=', 4)->orderBy('id', 'ASC')->get();
            }),
            'attributes' => ['disabled' => 'disabled']
          ],
          [
              'name' => 'college_id',
              'label' => "Universidad procedencia",
              'type' => 'select2_from_array',
              'options' => College::all()->pluck('name', 'id'),
              'allows_null' => false,
              'default' => $currentCollegeOrigin
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
              'default' => $currentCollegeDestination
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
            'label' => "Asignaturas equivalentes",
            'type' => "select2_from_ajax_multiple_custom",
            'name' => 'subject',
            'entity' => 'request',
            'attribute' => "name",
            'model' => "App\Models\Subject",
            'data_source' => url("/admin/api/subjectOrigin"),
            'placeholder' => "",
            'minimum_input_length' => 0,
            'pivot' => true,
            'dependencies' => ['college_id', 'career_origin_id'],
          ],
          //
          [
            'label' => 'Procedencia de su universidad',
            'name' => 'origin',
            'type' => 'toggle_only_read',
            'inline' => true,
            'options' => [
              1 => 'Nacional',
              2 => 'Extranjera'
            ],
            'hide_when' => [
              1 => ['ci_passport_copy', 'notes_legalized', 'study_program_legalized', 'cerification_category_college', 'certification_title_no_confered', 'translation'],
              2 => ['others', 'info_others', 'pensum', 'notes', 'study_programs', 'title', 'copy_ci', 'disciplinary_sanction']
            ],
            'default' => '',
            'attributes' => ['disabled' => 'disabled']
          ],
          //
          ['name' => 'others', 'label' => 'Otros documentos entregados', 'type' => 'checkbox'],
          //
          ['name' => 'info_others', 'label' => 'Descripción de otros documentos entregados', 'type' => 'textarea'],
          //
          ['name' => 'pensum', 'label' => 'Pensum', 'type' => 'checkbox'],
          //
          ['name' => 'notes', 'label' => 'Certificación de notas (original)', 'type' => 'checkbox'],
          //
          ['name' => 'study_programs', 'label' => 'Programas de estudios (autenticados)', 'type' => 'checkbox'],
          //
          ['name' => 'title', 'label' => 'Si es egresado universitario, copia del título', 'type' => 'checkbox'],
          //
          ['name' => 'copy_ci', 'label' => 'Fotocopia de la cédula de identidad', 'type' => 'checkbox'],
          //
          ['name' => 'ci_passport_copy', 'label' => 'Cédula de identidad o pasaporte (fotocopia)', 'type' => 'checkbox'],
          //
          ['name' => 'notes_legalized', 'label' => 'Certificación de notas, legalizadas por las autoridades competentes (original y copia)', 'type' => 'checkbox'],
          //
          ['name' => 'study_program_legalized', 'label' => 'Programas de estudios (originales, legalizados)', 'type' => 'checkbox'],
          //
          ['name' => 'cerification_category_college', 'label' => 'Certificación de la categoría universitaria del instituto de procedencia (oficialmente reconocida por las autoridades del país de origen)', 'type' => 'checkbox'],
          //
          ['name' => 'certification_title_no_confered', 'label' => 'Certificación en donde conste que no le ha sido conferido el título correspondiente (En caso de haber aprobado todos los años de estudio sin obtener el título)', 'type' => 'checkbox'],
          //
          ['name' => 'translation', 'label' => 'Traducción al castellano por interprete píblico autorizado, en caso de estar la documentación en idioma extranjero (original y fotocopia)', 'type' => 'checkbox'],
          //
          ['name' => 'disciplinary_sanction', 'label' => 'Constancia de no sanción disciplinaria', 'type' => 'checkbox'],
          //
          ['name' => 'voucher', 'label' => 'Voucher', 'type' => 'checkbox'],
          //
          ['name'=>'last_status', 'type' => 'text_custom', 'label' => 'Estatus actual'],
          //
          [ 'name' => 'estatus',
            'label' => "Estatus",
            'type' => 'select_from_array',
            'options' => [
              2 => 'Devuelta por falta de documentos',
              3 => 'Enviada a la Comisión de Reválidas y Equivalencias',
              4 => 'Enviada de la Subcomisión de Reválidas y Equivalencias',
              5 => 'Enviada al Consejo de Facultad',
              6 => 'Recibida por la Dirección de Reválidas y Equivalencias',
              7 => 'Enviada al Consejo Universitario',
              8 => 'Procesada'
            ],
            'allows_null' => true
          ]
        ], 'update');

        $this->crud->setColumns([
          ['name' => 'id',
          'label' =>'Número solicitud',
          'type' => 'text',
          'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere('requests.id', 'like', '%'.$searchTerm.'%');
            },
          ],
          //
          ['name' => 'user_id',
            'label' => "Cédula solicitante",
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'ci',
            'model' => "App\Models\User",
            'options'   => (function ($query) {
              return $query->orderBy('ci', 'ASC')->get();
            }),
            "key" => "ci",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('user', function ($q) use ($column, $searchTerm) {
                    $q->where('ci', 'like', '%'.$searchTerm.'%');
                });
            },

          ],
          //
          ['name' => 'user_id',
            'label' => "Nombre completo solicitante",
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'fullname',
            'model' => "App\Models\User",
            'options'   => (function ($query) {
              return $query->orderBy('ci', 'ASC')->get();
            }),
            "key" => "fullname",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('user', function ($q) use ($column, $searchTerm) {
                    $q->where('last_name', 'like', '%'.$searchTerm.'%');
                });
                $query->orWhereHas('user', function ($q) use ($column, $searchTerm) {
                    $q->where('first_name', 'like', '%'.$searchTerm.'%');
                });
            },
            "visibleInTable" => false
          ],
          //
          ['name' => 'date', 'label' => 'Fecha', 'type' => 'date'],
          //
          ['name' => 'college_career_origin',
            'label' => "Carrera procedencia",
            'type' => 'select',
            'entity' => 'career_origin',
            'attribute' => 'college_career_request',
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career_origin', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            },
            'limit' => 70
          ],
          //
          ['name' => 'college_career_destination',
            'label' => "Carrera destino",
            'type' => 'select',
            'entity' => 'career_destination',
            'attribute' => 'CollegeCareerRequest',
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career_destination', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            },
            'limit' => 70
          ],
          //
          ['name' => 'others', 'label' => 'Otros documentos entregados', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'info_others', 'label' => 'Descripción de otros documentos entregados', 'type' => 'textarea', 'visibleInTable' => false],
          //
          ['name' => 'pensum', 'label' => 'Pensum', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'notes', 'label' => 'Certificación de notas (original)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'study_programs', 'label' => 'Programas de estudios (autenticados)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'title', 'label' => 'Si es egresado universitario, copia del título', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'copy_ci', 'label' => 'Fotocopia de la cédula de identidad', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'disciplinary_sanction', 'label' => 'Constancia de no sanción disciplinaria', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0 => "No"], 'visibleInTable' => false],
          //
          ['name' => 'ci_passport_copy', 'label' => 'Cédula de identidad o pasaporte (fotocopia)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0 => "No"], 'visibleInTable' => false],
          //
          ['name' => 'notes_legalized', 'label' => 'Certificación de notas, legalizadas por las autoridades competentes (original y copia)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'study_program_legalized', 'label' => 'Programas de estudios (originales, legalizados)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'cerification_category_college',
            'label' => 'Certificación de la categoría universitaria del instituto de procedencia (oficialmente reconocida por las autoridades del país de origen)',
            'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'certification_title_no_confered',
            'label' => 'Certificación en donde conste que no le ha sido conferido el título correspondiente (En caso de haber aprobado todos los años de estudio sin obtener el título)',
            'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'translation', 'label' => 'Traducción al castellano por interprete público autorizado, en caso de estar la documentación en idioma extranjero (original y fotocopia)',
            'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name' => 'voucher', 'label' => 'Voucher', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          //
          ['name'=>'last_status', 'type' => 'text_custom', 'label' => 'Estatus actual', 'visibleInTable' => false]
        ]);


        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'id',
            'label'=> 'Número solicitud'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'requests.id', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'ci',
            'label'=> 'Cédula'
          ],
          false,
          function($value) {
            $this->crud->query = $this->crud->query->select('requests.*')
                                                  ->join('users', 'users.id', '=', 'requests.user_id')
                                                  ->where('users.ci', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'date',
            'name' => 'date',
            'label'=> 'Fecha',
          ],
          false,
          function($value) {
              $this->crud->addClause('where', 'date', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'college_origin_id',
            'label'=> 'Universidad procedencia',
            'placeholder' => 'Seleccione una Universidad'
          ],
          function(){
            return College::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
              $this->crud->query = $this->crud->query->select('requests.*')
                                                    ->join('careers as cfco', 'cfco.id', '=', 'requests.career_origin_id')
                                                    ->join('schools as sfco', 'sfco.id', '=', 'cfco.school_id')
                                                    ->join('colleges as cofco', 'cofco.id', '=', 'sfco.college_id')
                                                    ->where('cofco.id', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'college_destination_id',
            'label'=> 'Universidad destino',
            'placeholder' => 'Seleccione una Universidad'
          ],
          function(){
            return College::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
              $this->crud->query = $this->crud->query->select('requests.*')
                                                    ->join('careers as cfco', 'cfco.id', '=', 'requests.career_destination_id')
                                                    ->join('schools as sfco', 'sfco.id', '=', 'cfco.school_id')
                                                    ->join('colleges as cofco', 'cofco.id', '=', 'sfco.college_id')
                                                    ->where('cofco.id', '=', $value);
          }
        );

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $origin = Career::find($request->request->get('career_origin_id'));
        $request->request->set('date', Carbon::now());
        $redirect_location = parent::storeCrud($request);
        $lastRequestId = Request::orderBy('created_at', 'desc')->first();
        $lastRequestId = $lastRequestId->id;
        $today = Carbon::now();
        $insertStatus = DB::insert('INSERT INTO request_has_status VALUES (?, ?, ?, ?, ?)', [NULL, $lastRequestId, 1, $today, NULL]);
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {

        $selectedCollege = College::find($request->request->get('college_id'));
        if ($selectedCollege->foreign == 1) {
          $othersInfo = ($request->request->get('others') == 1) ? $request->request->get('info_others') : "" ;
          $request->request->set('info_others', $othersInfo);
          $request->request->set('ci_passport_copy', 0);
          $request->request->set('notes_legalized', 0);
          $request->request->set('study_program_legalized', 0);
          $request->request->set('cerification_category_college', 0);
          $request->request->set('certification_title_no_confered', 0);
          $request->request->set('translation', 0);
        }else {
          $request->request->set('others', 0);
          $request->request->set('info_others', "");
          $request->request->set('pensum', 0);
          $request->request->set('notes', 0);
          $request->request->set('study_programs', 0);
          $request->request->set('pensum', 0);
          $request->request->set('title', 0);
          $request->request->set('copy_ci', 0);
          $request->request->set('disciplinary_sanction', 0);
        }
        $redirect_location = parent::updateCrud($request);
        $today = Carbon::now();
        $insertStatus = DB::insert('INSERT INTO request_has_status VALUES (?, ?, ?, ?, ?)', [NULL, $request->request->get('id'), $request->request->get('estatus'), $today, NULL]);
        return $redirect_location;
    }

    public function generarPdfSolicitud($id){
      $currentRequest = Request::find($id);
      $currentUser = $currentRequest->user;

      // $currentUserOriginC = $currentRequest->career_origin ? $currentRequest->career_origin->name : "";
      // $currentUserOriginS = $currentRequest->career_origin ? $currentRequest->career_origin->school->name : "";
      // $currentUserOriginF = $currentRequest->career_origin ? $currentRequest->career_origin->school->faculty->name : "";
      // $currentUserOriginU = $currentRequest->career_origin ? $currentRequest->career_origin->school->faculty->college->name : "";
      //
      // $currentUserDestinationC = $currentRequest->career_destination ? $currentRequest->career_destination->name : "";
      // $currentUserDestinationS = $currentRequest->career_destination ? $currentRequest->career_destination->school->name : "";
      // $currentUserDestinationF = $currentRequest->career_destination ? $currentRequest->career_destination->school->faculty->name : "";
      // $currentUserDestinationU = $currentRequest->career_destination ? $currentRequest->career_destination->school->faculty->college->name : "";

      // $pdf = \PDF::loadView('backpack::crud.pdf.generarPdfSolicitud',
      //       compact("currentRequest", "currentUser", "currentUserOriginC", "currentUserOriginS", "currentUserOriginF", "currentUserOriginU",
      //               "currentUserDestinationC", "currentUserDestinationS", "currentUserDestinationF", "currentUserDestinationU"));
      $pdf = \PDF::loadView('backpack::crud.pdf.generarPdfSolicitud',
            compact("currentRequest", "currentUser"));
      return $pdf->stream();
    }
}
