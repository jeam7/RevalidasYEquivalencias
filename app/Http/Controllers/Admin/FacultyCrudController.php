<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\FacultyRequest as StoreRequest;
use App\Http\Requests\FacultyRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Input;
use App\Models\College;
/**
 * Class FacultyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class FacultyCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Faculty');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/faculty');
        $this->crud->setEntityNameStrings('Facultad', 'Facultades');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->setShowView('showFaculty');
        $this->crud->addButtonFromView('line', '', 'botonAnadirEscuela', 'bottom');

        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update', 'show' ]);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list', 'update', 'show' ]);
            break;
          default:
            break;
        }

        $college_from = Input::get('college_from');

        $this->crud->addFields([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          //
          [ 'name' => 'college_id',
            'label' => "Universidad",
            'type' => 'select2',
            'entity' => 'college',
            'attribute' => 'name_foreign',
            'model' => "App\Models\College",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'default' => $college_from
          ],
        ]);

        $this->crud->setColumns([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          //
          [ 'name' => 'collage_id',
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
              $this->crud->addClause('where', 'college_id', '=', $value);
          }
        );

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
