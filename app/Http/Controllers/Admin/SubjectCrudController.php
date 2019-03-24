<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SubjectRequest as StoreRequest;
use App\Http\Requests\SubjectRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

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

        $this->crud->denyAccess(['create', 'update', 'delete', 'list']);
        if(backpack_user()->type_user == 1 || backpack_user()->type_user == 2) {
          $this->crud->allowAccess(['create', 'update', 'list']);
        }elseif(backpack_user()->type_user == 3) {
          $this->crud->allowAccess(['create', 'list']);
        }

        $this->crud->addFields([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          ['name'=>'info', 'label'=>'Descripcion', 'type'=>'textarea'],
          ['name'=>'credits', 'label'=>'Unidades de credito', 'type'=>'number', 'attributes' => ["min" => "1"]],
          [ 'name' => 'career_id', // the db column for the foreign key
            'label' => "Carrera",
            'type' => 'select2',
            'entity' => 'career', // the method that defines the relationship in your Model
            'attribute' => 'career_school', // foreign key attribute that is shown to user
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
        ]);

        $this->crud->setColumns([
          ['name'=>'name', 'label'=>'Nombre', 'type'=>'text'],
          ['name'=>'info', 'label'=>'Descripcion', 'type'=>'text'],
          ['name'=>'credits', 'label'=>'Unidades de credito', 'type'=>'text'],
          [ 'name' => 'career_id', // the db column for the foreign key
            'label' => "Carrera",
            'type' => 'select',
            'entity' => 'career', // the method that defines the relationship in your Model
            'attribute' => 'career_school', // foreign key attribute that is shown to user
            'model' => "App\Models\Career",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
        ]);
        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

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
