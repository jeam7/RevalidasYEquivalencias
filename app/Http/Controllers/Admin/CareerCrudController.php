<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CareerRequest as StoreRequest;
use App\Http\Requests\CareerRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Input;
use App\Models\Career;
use App\Models\School;
use App\Models\Faculty;
use App\Models\College;
/**
 * Class CareerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CareerCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Career');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/career');
        $this->crud->setEntityNameStrings('Carrera', 'Carreras');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->setShowView('showCareer');
        $this->crud->addButtonFromView('line', '', 'botonAnadirAsignatura', 'bottom');

        $school_from = Input::get('school_from');
        if ($school_from != null) {
          $current = School::find($school_from);
          $currentSchool = $current ? $current->toArray()['id'] : NULL;
          $currentFaculty = $current ? $current->toArray()['faculty_id'] : NULL;
          $currentCollege = $current ? $current->toArray()['college_id'] : NULL;
        }else{
          $school_from = \Route::current()->parameter('career');
          $aux = Career::find($school_from);
          $current = $aux ? School::find($aux->school_id) : NULL;
          $currentSchool = $current ? $current->id : NULL;
          $currentFaculty = $current ? $current->faculty_id : NULL;
          $currentCollege = $current ? $current->college_id : NULL;
        }

        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update', 'show']);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list', 'update','show']);
            break;
          default:
            break;
        }

        $this->crud->addFields([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          //
          [
              'name' => 'college_id',
              'label' => "Universidad",
              'type' => 'select2_from_array',
              'options' => College::all()->pluck('name', 'id'),
              'allows_null' => false,
              'default' => $currentCollege
          ],
          //
          [
              'name' => 'faculty_id',
              'label' => "Facultad",
              'type' => 'select2_from_ajax_custom',
              'data_source' => url("/admin/api/faculty"),
              'placeholder' => '',
              'minimum_input_length' => 0,
              'method' => 'POST',
              'dependencies' => ['college_id'],
              'model' => 'App\Models\Faculty',
              'allows_null' => true,
              'default' => $currentFaculty,
              'attribute' => 'name',
              'entity' => 'School'
          ],
          //
          [
              'name' => 'school_id',
              'label' => "Escuela",
              'type' => 'select2_from_ajax_custom',
              'data_source' => url("/admin/api/school"),
              'placeholder' => '',
              'minimum_input_length' => 0,
              'method' => 'POST',
              'dependencies' => ['college_id'],
              'model' => 'App\Models\School',
              'default' => $currentSchool,
              'attribute' => 'name',
              'entity' => 'school'
          ]
        ]);

        $this->crud->setColumns([
          ['name'=>'name',
            'label'=>'Nombre',
            'type'=>'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('school', function ($q) use ($column, $searchTerm) {
                    $q->where('careers.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'college_name',
            'label'=>'Universidad',
            'type'=>'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('school', function ($q) use ($column, $searchTerm) {
                    $q->join('colleges as csl', 'csl.id', '=', 'schools.college_id')
                      ->where('csl.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'faculty_name',
            'label'=>'Facultad',
            'type'=>'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('school', function ($q) use ($column, $searchTerm) {
                    $q->join('faculties as fsl', 'fsl.id', '=', 'schools.faculty_id')
                      ->where('fsl.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          [ 'name' => 'school_id',
            'label' => "Escuela",
            'type' => 'select',
            'entity' => 'school',
            'attribute' => 'name',
            'model' => "App\Models\School",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('school', function ($q) use ($column, $searchTerm) {
                    $q->where('schools.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ]
        ]);

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'college_id',
            'label'=> 'Universidad',
            'placeholder' => 'Seleccione una Universidad'
          ],
          function(){
            return College::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
              $this->crud->query = $this->crud->query->select('careers.*')
                                                    ->join('schools as sfc', 'sfc.id', '=', 'careers.school_id')
                                                    ->where('sfc.college_id', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
          'name' => 'faculty_id',
          'type' => 'select2_ajax_faculty',
          'label'=> 'Facultad',
          'placeholder' => 'Seleccione una Facultad'
        ],
        url('admin/api/facultyFilterAjax'),
        function($value) {
          $this->crud->query = $this->crud->query->select('careers.*')
                                                ->join('schools as sff', 'sff.id', '=', 'careers.school_id')
                                                ->where('sff.faculty_id', '=', $value);
        });

        $this->crud->addFilter([
          'name' => 'school_id',
          'type' => 'select2_ajax_school',
          'label'=> 'Escuela',
          'placeholder' => 'Seleccione una Escuela'
        ],
        url('admin/api/schoolFilterAjax'),
        function($value) {
            $this->crud->addClause('where', 'school_id', '=', $value);
        });

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud($request);
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }
}
