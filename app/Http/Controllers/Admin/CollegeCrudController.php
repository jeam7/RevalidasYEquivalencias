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
        $this->crud->setEntityNameStrings('Universidad', 'Universidades');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->setShowView('showCollege');
        $this->crud->addButtonFromView('line', '', 'botonAnadirFacultad', 'bottom');

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

        $this->crud->addFields([
          ['name' => 'name', 'label' => 'Nombre', 'type' => 'text'],
          //
          ['name' => 'foreign',
            'label' => 'Nacional o extranjera',
            'type' => 'select_from_array',
            'options' => [1 => 'Nacional', 2 => 'Extrajera']
          ],
          //
          ['name' => 'address', 'label' => 'Dirección', 'type' => 'textarea'],
          //
          ['name' => 'abbreviation', 'label' => 'Abreviación', 'type' => 'text']
        ]);

        $this->crud->setColumns([
          ['name' => 'name', 'label' => 'Nombre', 'type' => 'text'],
          //
          ['name' => 'foreign',
            'label' => 'Nacional o extranjera',
            'type' => 'select_from_array',
            'options' => [1 => 'Nacional', 2 => 'Extrajera']
          ],
          //
          ['name' => 'abbreviation', 'label' => 'Abreviación', 'type' => 'text'],
          //
          ['name' => 'address', 'label' => 'Dirección', 'type' => 'text', 'visibleInTable' => false]
        ]);

        $this->crud->addFilter([
          'name' => 'foreign',
          'type' => 'dropdown',
          'label'=> 'Nacional o extranjera'
        ], [
          1 => 'Nacional',
          2 => 'Extranjera'
        ], function($value) {
            $this->crud->addClause('where', 'foreign', $value);
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
