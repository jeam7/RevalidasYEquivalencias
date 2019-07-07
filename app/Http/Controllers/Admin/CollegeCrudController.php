<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CollegeRequest as StoreRequest;
use App\Http\Requests\CollegeRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CollegeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CollegeCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\College');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/college');
        $this->crud->setEntityNameStrings('universidad', 'Universidades');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);

        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update', 'show' ]);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list', 'show']);
            break;
          default:
            break;
        }

        $this->crud->addFields([
          ['name' => 'name', 'label' => 'Nombre', 'type' => 'text'],
          ['name' => 'foreign',
            'label' => 'Nacional o extranjera',
            'type' => 'select_from_array',
            'options' => [1 => 'Nacional', 2 => 'Extrajera']
          ],
          ['name' => 'address', 'label' => 'Direccion', 'type' => 'textarea'],
          ['name' => 'abbreviation', 'label' => 'Abreviacion', 'type' => 'text']
        ]);
        $this->crud->setColumns([
          ['name' => 'name', 'label' => 'Nombre', 'type' => 'text'],
          ['name' => 'foreign',
            'label' => 'Nacional o extranjera',
            'type' => 'select_from_array',
            'options' => [1 => 'Nacional', 2 => 'Extrajera']
          ],
          ['name' => 'abbreviation', 'label' => 'Abreviacion', 'type' => 'text'],
          ['name' => 'address', 'label' => 'Direccion', 'type' => 'text', 'visibleInTable' => false]
        ]);

        $this->crud->addFilter([ // dropdown filter
          'name' => 'foreign',
          'type' => 'dropdown',
          'label'=> 'Nacional o extranjera'
        ], [
          1 => 'Nacional',
          2 => 'Extranjera'
        ], function($value) { // if the filter is active
            $this->crud->addClause('where', 'foreign', $value);
        });

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in CollegeRequest
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
