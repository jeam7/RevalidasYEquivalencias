<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Equivalent_subjectRequest as StoreRequest;
use App\Http\Requests\Equivalent_subjectRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class Equivalent_subjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Equivalent_subjectCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Equivalent_subject');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/equivalent_subject');
        $this->crud->setEntityNameStrings('equivalent_subject', 'equivalent_subjects');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addFields([
            ['name' => 'voucher_id', // the db column for the foreign key
              'label' => "Numero de comprobante",
              'type' => 'select2',
              'entity' => 'voucher', // the method that defines the relationship in your Model
              'attribute' => 'id', // foreign key attribute that is shown to user
              'model' => "App\Models\Voucher",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'subject_a_id', // the db column for the foreign key
              'label' => "Asignatura equivalente aprobada",
              'type' => 'select2',
              'entity' => 'subject_a', // the method that defines the relationship in your Model
              'attribute' => 'subject_faculty', // foreign key attribute that is shown to user
              'model' => "App\Models\Subject",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'subject_e_id', // the db column for the foreign key
              'label' => "Codigo de materias",
              'type' => 'select2_multiple',
              'entity' => 'subject_e', // the method that defines the relationship in your Model
              'attribute' => 'subject_faculty', // foreign key attribute that is shown to user
              'model' => "App\Models\Subject",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ]
        ]);
        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in Equivalent_subjectRequest
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
