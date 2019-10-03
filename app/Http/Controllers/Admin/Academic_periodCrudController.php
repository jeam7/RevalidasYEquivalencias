<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Academic_periodRequest as StoreRequest;
use App\Http\Requests\Academic_periodRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Models\Faculty;

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
        $this->crud->setEntityNameStrings('Período Académico', 'Períodos Académicos');

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
            'attribute' => 'name',
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              if (backpack_user()->type_user == 2) {
                return $query->where('id', '=', backpack_user()->faculty_id)->orderBy('id', 'ASC')->get();
              }
              return $query->where('college_id', '=', 1)->orderBy('id', 'ASC')->get();
            }),
            'default' => backpack_user()->faculty_id
          ],
          //
          ['name'=>'name', 'label'=>'Nombre período académico', 'type'=>'text'],
          //
          ['name'=>'info', 'label'=>'Descripción', 'type'=>'textarea'],
          //
          ['name'=>'dean', 'label'=>'Decano', 'type'=>'text'],
          //
          ['name'=>'rep_sub_equi_one', 'label'=>'Primer representante de Subcomisión de Equivalencias', 'type'=>'text'],
          //
          ['name'=>'rep_sub_equi_two', 'label'=>'Segundo representante de Subcomisión de Equivalencias', 'type'=>'text'],
          //
          ['name'=>'rep_sub_equi_three', 'label'=>'Tercer representante de Subcomisión de Equivalencias', 'type'=>'text'],
          //
          ['name'=>'rep_comi_equi_one', 'label'=>'Primer representante de Comisión de Equivalencias', 'type'=>'text'],
          //
          ['name'=>'rep_comi_equi_two', 'label'=>'Segundo representante de Comisión de Equivalencias', 'type'=>'text'],
          //
          ['name'=>'rep_comi_equi_three', 'label'=>'Tercer representante de Comisión de Equivalencias', 'type'=>'text'],
        ]);

        $this->crud->setColumns([
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
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            }
          ],
          //
          ['name'=>'name', 'label'=>'Nombre período académico', 'type'=>'text'],
          //
          ['name'=>'dean', 'label'=>'Decano', 'type'=>'text'],
          //
          ['name'=>'info', 'label'=>'Descripción', 'type'=>'text', 'visibleInTable' => false],
          ['name'=>'rep_sub_equi_one', 'label'=>'Primer representante de Subcomisión de Equivalencias', 'type'=>'text', 'visibleInTable' => false],
          //
          ['name'=>'rep_sub_equi_two', 'label'=>'Segundo representante de Subcomisión de Equivalencias', 'type'=>'text', 'visibleInTable' => false],
          //
          ['name'=>'rep_sub_equi_three', 'label'=>'Tercer representante de Subcomisión de Equivalencias', 'type'=>'text', 'visibleInTable' => false],
          //
          ['name'=>'rep_comi_equi_one', 'label'=>'Primer representante de Comisión de Equivalencias', 'type'=>'text', 'visibleInTable' => false],
          //
          ['name'=>'rep_comi_equi_two', 'label'=>'Segundo representante de Comisión de Equivalencias', 'type'=>'text', 'visibleInTable' => false],
          //
          ['name'=>'rep_comi_equi_three', 'label'=>'Tercer representante de Comisión de Equivalencias', 'type'=>'text', 'visibleInTable' => false]
        ]);

        if (backpack_user()->type_user == 1) {
          $this->crud->addFilter([
              'type' => 'select2',
              'name' => 'faculty_id',
              'label'=> 'Facultad'
            ],
            function(){
              $facultiesUCV = Faculty::whereHas('college', function($q){
                                                  $q->where('id', 1);
                                                })->get()
                                                ->pluck('name', 'id')
                                                ->toArray();
              return $facultiesUCV;
            },
            function($value) {
                $this->crud->addClause('where', 'faculty_id', '=', $value);
            }
          );
        }

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
