<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Academic_periodRequest as StoreRequest;
use App\Http\Requests\Academic_periodRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class Academic_periodCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Academic_periodCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Academic_period');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/academic_period');
        $this->crud->setEntityNameStrings('Periodo Academico', 'Periodos Academicos');

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
            $this->crud->allowAccess(['create', 'list', 'update', 'show']);
            $this->crud->addClause('where', 'faculty_id', '=', backpack_user()->faculty_id);
            break;
          default:
            break;
        }

        $this->crud->addFields([
          [ 'name' => 'faculty_id',
            'label' => "Facultad",
            'type' => 'select2',
            'entity' => 'faculty',
            'attribute' => 'faculty_college',
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              if (backpack_user()->type_user == 2) {
                return $query->where('id', '=', backpack_user()->faculty_id)->orderBy('id', 'ASC')->get();
              }
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
          ['name'=>'name', 'label'=>'Nombre periodo academico', 'type'=>'text'],
          ['name'=>'info', 'label'=>'Descripcion', 'type'=>'textarea'],
          ['name'=>'dean', 'label'=>'Decano', 'type'=>'text'],
          ['name'=>'rep_sub_equi_one', 'label'=>'Primer representante de subcomision de equivalencias', 'type'=>'text'],
          ['name'=>'rep_sub_equi_two', 'label'=>'Segundo representante de subcomision de equivalencias', 'type'=>'text'],
          ['name'=>'rep_sub_equi_three', 'label'=>'Tercer representante de subcomision de equivalencias', 'type'=>'text'],

          ['name'=>'rep_comi_equi_one', 'label'=>'Primer representante de comision de equivalencias', 'type'=>'text'],
          ['name'=>'rep_comi_equi_two', 'label'=>'Segundo representante de comision de equivalencias', 'type'=>'text'],
          ['name'=>'rep_comi_equi_three', 'label'=>'Tercer representante de comision de equivalencias', 'type'=>'text'],
        ]);

        $this->crud->setColumns([
          [ 'name' => 'faculty_id',
            'label' => "Facultad",
            'type' => 'select',
            'entity' => 'faculty',
            'attribute' => 'faculty_college',
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            }),
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('faculty', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          ['name'=>'name', 'label'=>'Nombre periodo academico', 'type'=>'text'],
          ['name'=>'dean', 'label'=>'Decano', 'type'=>'text'],
          ['name'=>'info', 'label'=>'Descripcion', 'type'=>'text', 'visibleInTable' => false],
          ['name'=>'rep_sub_equi_one', 'label'=>'Primer representante de subcomision de equivalencias', 'type'=>'text', 'visibleInTable' => false],
          ['name'=>'rep_sub_equi_two', 'label'=>'Segundo representante de subcomision de equivalencias', 'type'=>'text', 'visibleInTable' => false],
          ['name'=>'rep_sub_equi_three', 'label'=>'Tercer representante de subcomision de equivalencias', 'type'=>'text', 'visibleInTable' => false],

          ['name'=>'rep_comi_equi_one', 'label'=>'Primer representante de comision de equivalencias', 'type'=>'text', 'visibleInTable' => false],
          ['name'=>'rep_comi_equi_two', 'label'=>'Segundo representante de comision de equivalencias', 'type'=>'text', 'visibleInTable' => false],
          ['name'=>'rep_comi_equi_three', 'label'=>'Tercer representante de comision de equivalencias', 'type'=>'text', 'visibleInTable' => false]
        ]);

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'faculty_id',
            'label'=> 'Facultad'
          ],
          function(){
            return \App\Models\Faculty::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
              $this->crud->addClause('where', 'faculty_id', '=', $value);
          }
        );

        // $this->crud->addFilter([
        //     'type' => 'text',
        //     'name' => 'name',
        //     'label'=> 'Periodo academico'
        //   ],
        //   false,
        //   function($value) {
        //     $this->crud->addClause('where', 'name', '=', $value);
        //   }
        // );
        // add asterisk for fields that are required in Academic_periodRequest
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
