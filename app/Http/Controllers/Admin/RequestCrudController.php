<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RequestRequest as StoreRequest;
use App\Http\Requests\RequestRequestUpdate as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\DB;
use App\Models\Request;
use App\Models\Career;
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
        $this->crud->addButtonFromView('line', '', 'botonGenerarPdfSolicitud', 'bottom');

        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show' ]);
            $this->crud->addClause('requestByFaculty', backpack_user()->faculty_id);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list', 'update', 'show']);
            $this->crud->addClause('requestByFaculty', backpack_user()->faculty_id);
            break;
          default:
            break;
        }

        $this->crud->addFields([
            ['name' => 'user_id',
              'label' => "Cedula solicitante",
              'type' => 'select2',
              'entity' => 'user',
              'attribute' => 'user_fullname',
              'model' => "App\Models\User",
              'options'   => (function ($query) {
                return $query->where('type_user','=', 4)->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'career_origin_id',
              'label' => "Carrera - Facultad - Universidad de procedencia",
              'type' => 'select2',
              'entity' => 'career_origin',
              'attribute' => 'career_faculty_college',
              'model' => "App\Models\Career",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'career_destination_id',
              'label' => "Carrera - Facultad - Universidad donde desea cursar",
              'type' => 'select2',
              'entity' => 'career_destination',
              'attribute' => 'career_faculty_college',
              'model' => "App\Models\Career",
              'options'   => (function ($query) {
                if (backpack_user()->type_user == 3 || backpack_user()->type_user == 2) {
                  return $query->select('careers.*')
                                ->join('schools', 'schools.id', '=', 'careers.school_id')
                                ->where('schools.faculty_id', '=', backpack_user()->faculty_id)
                                ->orderBy('id', 'ASC')->get();
                }else{
                  return $query->orderBy('id', 'ASC')->get();
                }

              })
            ]
        ], 'create');


        $this->crud->addFields([
          ['name' => 'user_id',
            'label' => "Cedula solicitante",
            'type' => 'select2',
            'entity' => 'user',
            'attribute' => 'user_fullname',
            'model' => "App\Models\User",
            'options'   => (function ($query) {
              return $query->where('type_user','=', 4)->orderBy('id', 'ASC')->get();
            }),
            'attributes' => ['disabled' => 'disabled']
          ],
          ['name' => 'career_origin_id',
            'label' => "Carrera - Facultad - Universidad de procedencia",
            'type' => 'select2',
            'entity' => 'career_origin',
            'attribute' => 'career_faculty_college',
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'attributes' => ['disabled' => 'disabled']
          ],
          ['name' => 'career_destination_id',
            'label' => "Carrera - Facultad - Universidad donde desea cursar",
            'type' => 'select2',
            'entity' => 'career_destination',
            'attribute' => 'career_faculty_college',
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'attributes' => ['disabled' => 'disabled']
          ],
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
              2 => ['others', 'info_others', 'pensum', 'notes', 'study_programs', 'title', 'copy_ci']
            ],
            'default' => \Route::current()->parameter('origin'),
            'attributes' => ['disabled' => 'disabled']
          ],
          ['name' => 'others', 'label' => 'Otros documentos entregados', 'type' => 'checkbox'],
          ['name' => 'info_others', 'label' => 'Descripcion de otros documentos entregados', 'type' => 'textarea'],
          ['name' => 'pensum', 'label' => 'Pensum', 'type' => 'checkbox'],
          ['name' => 'notes', 'label' => 'Certificacion de notas (original)', 'type' => 'checkbox'],
          ['name' => 'study_programs', 'label' => 'Programas de estudios (autenticados)', 'type' => 'checkbox'],
          ['name' => 'title', 'label' => 'Si es egresado universitario, copia del titulo', 'type' => 'checkbox'],
          ['name' => 'copy_ci', 'label' => 'Fotocopia de la cedula de identidad', 'type' => 'checkbox'],
          ['name' => 'ci_passport_copy', 'label' => 'Cedula de identidad o pasaporte (fotocopia)', 'type' => 'checkbox'],
          ['name' => 'notes_legalized', 'label' => 'Certificacion de notas, legalizadas por las autoridades competentes (original y copia)', 'type' => 'checkbox'],
          ['name' => 'study_program_legalized', 'label' => 'Programas de estudios (originales, legalizados)', 'type' => 'checkbox'],
          ['name' => 'cerification_category_college', 'label' => 'Certificacion de la categoria universitaria del instituto de procedencia (oficialmente reconocida por las autoridades del pais de origen)', 'type' => 'checkbox'],
          ['name' => 'certification_title_no_confered', 'label' => 'Certificacion en donde conste que no le ha sido conferido el titulo correspondiente (En caso de haber aprobado todos los anos de estudio sin obtener el titulo)', 'type' => 'checkbox'],
          ['name' => 'translation', 'label' => 'Traduccion al castellano por interprete publico autorizado, en caso de estar la documentacion en idioma extranjero (original y fotocopia)', 'type' => 'checkbox'],
          ['name'=>'last_status', 'type' => 'text_custom', 'label' => 'Estatus actual'],
          [ 'name' => 'estatus',
            'label' => "Estatus",
            'type' => 'select_from_array',
            'options' => [
              2 => 'Devuelta por falta de documentos',
              3 => 'Enviada a la comision de revalidas y equivalencias',
              4 => 'Enviada de la subcomision de revalidas y equivalencias',
              5 => 'Enviada al consejo de facultad',
              6 => 'Recibida por la direccion de revalidas y equivalencias',
              7 => 'Enviada al consejo universitario',
              8 => 'Procesada'
            ],
            'allows_null' => true
          ]
        ], 'update');

        $this->crud->setColumns([
          ['name' => 'id',
          'label' =>
          'Número solicitud',
          'type' => 'text',
          'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere('requests.id', 'like', '%'.$searchTerm.'%');
            },
          ],
          ['name' => 'user_id',
            'label' => "Cedula solicitante",
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
            }
          ],
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
          ['name' => 'date', 'label' => 'Fecha', 'type' => 'date'],
          ['name' => 'career_origin_id',
            'label' => "Universidad - Carrera (Procedencia)",
            'type' => 'select',
            'entity' => 'career_origin',
            'attribute' => 'college_faculty',
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career_origin', function ($q) use ($column, $searchTerm) {
                    $q->where('careers.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          ['name' => 'career_destination_id',
            'label' => "Universidad - Carrera (Destino)",
            'type' => 'select',
            'entity' => 'career_destination',
            'attribute' => 'college_faculty',
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career_destination', function ($q) use ($column, $searchTerm) {
                    $q->where('careers.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          ['name' => 'others', 'label' => 'Otros documentos entregados', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'info_others', 'label' => 'Descripcion de otros documentos entregados', 'type' => 'textarea', 'visibleInTable' => false],
          ['name' => 'pensum', 'label' => 'Pensum', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'notes', 'label' => 'Certificacion de notas (original)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'study_programs', 'label' => 'Programas de estudios (autenticados)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'title', 'label' => 'Si es egresado universitario, copia del titulo', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'copy_ci', 'label' => 'Fotocopia de la cedula de identidad', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'ci_passport_copy', 'label' => 'Cedula de identidad o pasaporte (fotocopia)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'notes_legalized', 'label' => 'Certificacion de notas, legalizadas por las autoridades competentes (original y copia)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'study_program_legalized', 'label' => 'Programas de estudios (originales, legalizados)', 'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'cerification_category_college',
            'label' => 'Certificacion de la categoria universitaria del instituto de procedencia (oficialmente reconocida por las autoridades del pais de origen)',
            'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'certification_title_no_confered',
            'label' => 'Certificacion en donde conste que no le ha sido conferido el titulo correspondiente (En caso de haber aprobado todos los anos de estudio sin obtener el titulo)',
            'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name' => 'translation', 'label' => 'Traduccion al castellano por interprete publico autorizado, en caso de estar la documentacion en idioma extranjero (original y fotocopia)',
            'type' => 'select_from_array', 'options' =>[1 => 'Si', 0=> "No"], 'visibleInTable' => false],
          ['name'=>'last_status', 'type' => 'text_custom', 'label' => 'Estatus actual', 'visibleInTable' => false]
        ]);


        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'id',
            'label'=> 'Numero solicitud'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'requests.id', '=', $value);
          }
        );

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'ci',
            'label'=> 'Cedula'
          ],
          false,
          function($value) {
            $this->crud->query = $this->crud->query->select('requests.*')
                                                  ->join('users', 'users.id', '=', 'requests.user_id')
                                                  ->where('users.ci', '=', $value);
          }
        );

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

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'career_origin',
            'label'=> 'Carrera procedencia'
          ],
          function(){
            return \App\Models\Career::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
            $this->crud->addClause('where', 'career_origin_id', '=', $value);
          }
        );
        // dd(\App\Models\Career::vainilla()->pluck('careers.name', 'careers.id')->toArray());
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->addFilter([
                'type' => 'select2',
                'name' => 'career_destination',
                'label'=> 'Carrera destino'
              ],
              function(){
                return \App\Models\Career::all()->pluck('name', 'id')->toArray();
              },
              function($value) {
                $this->crud->addClause('where', 'career_destination_id', '=', $value);
              }
            );
            break;
          case 2:
            $this->crud->addFilter([
                'type' => 'select2',
                'name' => 'career_destination',
                'label'=> 'Carrera destino'
              ],
              function(){
                return \App\Models\Career::careersByFaculty(backpack_user()->faculty_id)->pluck('careers.name', 'careers.id')->toArray();
              },
              function($value) {
                $this->crud->addClause('where', 'career_destination_id', '=', $value);
              }
            );
            break;
          case 3:
            $this->crud->addFilter([
                'type' => 'select2',
                'name' => 'career_destination',
                'label'=> 'Carrera destino'
              ],
              function(){
                return \App\Models\Career::careersByFaculty(backpack_user()->faculty_id)->pluck('careers.name', 'careers.id')->toArray();
              },
              function($value) {
                $this->crud->addClause('where', 'career_destination_id', '=', $value);
              }
            );
            break;
          default:
            break;
        }

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in RequestRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // dd($request->request);
        // your additional operations before save here

          $origin = Career::find($request->request->get('career_origin_id'));
          $request->request->set('origin', $origin->school->faculty->college->foreign);
          $request->request->set('date', Carbon::now());

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

    public function generarPdfSolicitud($id){
      $currentRequest = Request::find($id);
      $currentUser = $currentRequest->user;

      $currentUserOriginC = $currentRequest->career_origin ? $currentRequest->career_origin->name : "";
      $currentUserOriginS = $currentRequest->career_origin ? $currentRequest->career_origin->school->name : "";
      $currentUserOriginF = $currentRequest->career_origin ? $currentRequest->career_origin->school->faculty->name : "";
      $currentUserOriginU = $currentRequest->career_origin ? $currentRequest->career_origin->school->faculty->college->name : "";

      $currentUserDestinationC = $currentRequest->career_destination ? $currentRequest->career_destination->name : "";
      $currentUserDestinationS = $currentRequest->career_destination ? $currentRequest->career_destination->school->name : "";
      $currentUserDestinationF = $currentRequest->career_destination ? $currentRequest->career_destination->school->faculty->name : "";
      $currentUserDestinationU = $currentRequest->career_destination ? $currentRequest->career_destination->school->faculty->college->name : "";

      $pdf = \PDF::loadView('backpack::crud.pdf.generarPdfSolicitud',
            compact("currentRequest", "currentUser", "currentUserOriginC", "currentUserOriginS", "currentUserOriginF", "currentUserOriginU",
                    "currentUserDestinationC", "currentUserDestinationS", "currentUserDestinationF", "currentUserDestinationU"));
      return $pdf->stream();
    }
}
