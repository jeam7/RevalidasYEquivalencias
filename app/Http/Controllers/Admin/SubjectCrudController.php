<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SubjectRequest as StoreRequest;
use App\Http\Requests\SubjectRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Input;
use App\Models\Subject;
use App\Models\Career;
use App\Models\School;
use App\Models\Faculty;
use App\Models\College;
/**
 * Class SubjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubjectCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Subject');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subject');
        $this->crud->setEntityNameStrings('Asignatura', 'Asignaturas');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $career_from = Input::get('career_from');
        if ($career_from != null) {
          $current = Career::find($career_from);
          $currentCareer = $current ? $current->toArray()['id'] : NULL;
          $current = $current->school ? $current->school : NULL;
          $currentSchool = $current ? $current->toArray()['id'] : NULL;
          $currentFaculty = $current ? $current->toArray()['faculty_id'] : NULL;
          $currentCollege = $current ? $current->toArray()['college_id'] : NULL;
        }else{
          $career_from = \Route::current()->parameter('subject');
          $aux = Subject::find($career_from);
          $currentCareer = $aux ? $aux->career->id : NULL;
          $currentSchool = $aux ? $aux->career->school->id : NULL;
          $currentFaculty = $aux ? $aux->career->school->faculty_id : NULL;
          $currentCollege = $aux ? $aux->career->school->college_id : NULL;
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
            $this->crud->allowAccess(['create', 'list', 'update', 'show']);
            break;
          default:
            break;
        }

        $this->crud->addFields([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          //
          ['name'=>'code', 'label'=>'Código', 'type'=>'text'],
          //
          ['name'=>'info', 'label'=>'Descripción', 'type'=>'textarea'],
          //
          ['name'=>'credits', 'label'=>'Unidades de crédito', 'type'=>'number', 'attributes' => ["min" => "1"]],
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
              'entity' => 'Career'
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
              'dependencies' => ['college_id', 'faculty_id'],
              'model' => 'App\Models\School',
              'default' => $currentSchool,
              'attribute' => 'name',
              'entity' => 'Career'
          ],
          //
          [
              'name' => 'career_id',
              'label' => "Carrera",
              'type' => 'select2_from_ajax_custom',
              'data_source' => url("/admin/api/career"),
              'placeholder' => '',
              'minimum_input_length' => 0,
              'method' => 'POST',
              'dependencies' => ['college_id', 'faculty_id', 'school_id'],
              'model' => 'App\Models\Career',
              'default' => $currentCareer,
              'attribute' => 'careers.name',
              'entity' => 'career'
          ]
        ]);

        $this->crud->setColumns([
          ['name'=>'name',
            'label'=>'Nombre',
            'type'=>'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career', function ($q) use ($column, $searchTerm) {
                    $q->where('subjects.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'code', 'label'=>'Código', 'type'=>'text', 'visibleInShow' => true, 'visibleInTable' => false],
          //
          ['name'=>'credits', 'label'=>'Unidades de crédito', 'type'=>'text', 'visibleInShow' => true, 'visibleInTable' => false],
          //
          ['name'=>'college_name',
            'label'=>'Universidad',
            'type'=>'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career', function ($q) use ($column, $searchTerm) {
                    $q->join('schools as ssl', 'ssl.id', '=', 'careers.school_id')
                      ->join('colleges as csl', 'csl.id', '=', 'ssl.college_id')
                      ->where('csl.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'faculty_name',
            'label'=>'Facultad',
            'type'=>'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career', function ($q) use ($column, $searchTerm) {
                    $q->join('schools as ssl', 'ssl.id', '=', 'careers.school_id')
                      ->join('faculties as fsl', 'fsl.id', '=', 'ssl.faculty_id')
                      ->where('fsl.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'school_name',
            'label'=>'Escuela',
            'type'=>'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career', function ($q) use ($column, $searchTerm) {
                    $q->join('schools as ssl', 'ssl.id', '=', 'careers.school_id')
                      ->where('ssl.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          [ 'name' => 'career_id',
            'label' => "Carrera",
            'type' => 'select',
            'entity' => 'career',
            'attribute' => 'name',
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('career', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'info', 'label'=>'Descripción', 'type'=>'text', 'visibleInTable' => false]
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
              $this->crud->query = $this->crud->query->select('subjects.*')
                                                    ->join('careers as cfc', 'cfc.id', '=', 'subjects.career_id')
                                                    ->join('schools as sfc', 'sfc.id', '=', 'cfc.school_id')
                                                    ->join('colleges as cofc', 'cofc.id', '=', 'sfc.college_id')
                                                    ->where('cofc.id', '=', $value);
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
          $this->crud->query = $this->crud->query->select('subjects.*')
                                                ->join('careers as cff', 'cff.id', '=', 'subjects.career_id')
                                                ->join('schools as sff', 'sff.id', '=', 'cff.school_id')
                                                ->join('faculties as fff', 'fff.id', '=', 'sff.faculty_id')
                                                ->where('fff.id', '=', $value);
        });
        //
        $this->crud->addFilter([
          'name' => 'school_id',
          'type' => 'select2_ajax_school',
          'label'=> 'Escuela',
          'placeholder' => 'Seleccione una Escuela'
        ],
        url('admin/api/schoolFilterAjax'),
        function($value) {
          $this->crud->query = $this->crud->query->select('subjects.*')
                                                ->join('careers as cfs', 'cfs.id', '=', 'subjects.career_id')
                                                ->join('schools as sfs', 'sfs.id', '=', 'cfs.school_id')
                                                ->where('sfs.id', '=', $value);
        });
        //
        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'career_id',
            'label'=> 'Carrera'
          ],
          function(){
            return \App\Models\Career::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
              $this->crud->addClause('where', 'career_id', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'code',
            'label'=> 'Código'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'code', '=', $value);
          }
        );


        // add asterisk for fields that are required in SubjectRequest
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
}
