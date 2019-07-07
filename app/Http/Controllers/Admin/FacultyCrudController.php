<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\FacultyRequest as StoreRequest;
use App\Http\Requests\FacultyRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

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

        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete']);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update']);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list']);
            break;
          default:
            break;
        }

        $this->crud->addFields([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          [ 'name' => 'college_id', // the db column for the foreign key
            'label' => "Universidad",
            'type' => 'select2',
            'entity' => 'college', // the method that defines the relationship in your Model
            'attribute' => 'name_foreign', // foreign key attribute that is shown to user
            'model' => "App\Models\College",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
        ]);

        $this->crud->setColumns([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          [ 'name' => 'collage_id', // the db column for the foreign key
            'label' => "Universidad",
            'type' => 'select',
            'entity' => 'college', // the method that defines the relationship in your Model
            'attribute' => 'name_foreign', // foreign key attribute that is shown to user
            'model' => "App\Models\College",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ]
        ]);

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'college_id',
            'label'=> 'Universidad'
          ],
          function(){
            return \App\Models\College::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
              $this->crud->addClause('where', 'college_id', '=', $value);
          }
        );
        // add asterisk for fields that are required in FacultyRequest
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
