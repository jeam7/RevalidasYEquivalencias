<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SchoolRequest as StoreRequest;
use App\Http\Requests\SchoolRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Input;
use App\Models\School;
use App\Models\Faculty;
use App\Models\College;
/**
 * Class SchoolCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SchoolCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\School');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/school');
        $this->crud->setEntityNameStrings('Escuela', 'Escuelas');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->setShowView('showSchool');
        $this->crud->addButtonFromView('line', '', 'botonAnadirCarrera', 'bottom');

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

        $faculty_from = Input::get('faculty_from');
        $currentFaculty = "";
        $currentCollege = "";
        if ($faculty_from != null) {
          $current = Faculty::find($faculty_from);
          $currentFaculty = $current ? $current->id : NULL;
          $currentCollege = $current ? $current->college_id : NULL;
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
            'label' => "Facultad",
            'type' => "select2_from_ajax",
            'name' => 'faculty_id',
            'entity' => 'Faculty',
            'attribute' => "name",
            'model' => "App\Models\Faculty",
            'data_source' => url("/admin/api/faculty"),
            'placeholder' => "",
            'minimum_input_length' => 0,
            'dependencies' => ['college_id'],
            'method' => 'POST',
            'default' => $faculty_from
          ],
        ]);

        $this->crud->setColumns([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          //
          [ 'name' => 'college_id',
            'label' => "Universidad",
            'type' => 'select',
            'entity' => 'college',
            'attribute' => 'name_foreign',
            'model' => "App\Models\College",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('college', function ($q) use ($column, $searchTerm) {
                    $q->where('colleges.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          [ 'name' => 'faculty_id',
            'label' => "Facultad",
            'type' => 'select',
            'entity' => 'faculty',
            'attribute' => 'name',
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('faculty', function ($q) use ($column, $searchTerm) {
                    $q->where('faculties.name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
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
              $this->crud->addClause('where', 'college_id', '=', $value);
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
            $this->crud->addClause('where', 'faculty_id', '=', $value);
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
