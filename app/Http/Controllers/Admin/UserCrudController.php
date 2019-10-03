<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Faculty;
/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user');
        $this->crud->setEntityNameStrings('Usuario', 'Usuarios');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            $this->crud->addClause('where', 'id', '!=', backpack_user()->id);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            $this->crud->addClause('myFaculty', backpack_user()->faculty_id);
            $this->crud->addClause('where', 'id', '!=', backpack_user()->id);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list', 'update','show']);
            $this->crud->addClause('where', 'type_user', '=', 4);
            break;
          default:
            break;
        }

        $this->crud->addFields([
          ['name'=>'ci', 'label'=>'Cédula', 'type'=>'text'],
          //
          ['name'=>'first_name', 'label'=>'Nombre', 'type'=>'text'],
          //
          ['name'=>'last_name', 'label'=>'Apellido', 'type'=>'text'],
          //
          ['name'=>'place_birth', 'label'=>'Lugar de nacimiento', 'type'=>'text'],
          //
          ['name' => 'nacionality',
            'label' => "Nacionalidad",
            'type' => 'select_from_array',
            'options' => ['v' => 'Venezolano', 'e' => 'Extranjero']
          ],
          //
          ['name'=>'birthdate', 'label'=>'Fecha de nacimiento', 'type'=>'date'],
          //
          ['name' => 'gender',
            'label' => "Género",
            'type' => 'select_from_array',
            'options' => ['f' => 'Femenino', 'm' => 'Masculino']
          ],
          //
          ['name'=>'address', 'label'=>'Dirección', 'type'=>'textarea'],
          //
          ['name'=>'phone', 'label'=>'Teléfono', 'type'=>'text'],
          //
          ['name'=>'email', 'label'=>'Correo', 'type'=>'email'],
        ]);

        if (backpack_user()->type_user == 1) {
          $this->crud->addField([
            'label' => 'Tipo de usuario',
            'name' => 'type_user',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
              2 => 'Personal Administrativo de Reválidas y Equivalencias',
              3 => 'Personal Interno de Reválidas y Equivalencias',
              4 => 'Solicitante'
            ],
            'hide_when' => [
              4 => ['faculty_id'],
              ],
            'default' => 4
          ]);
          //
          $this->crud->addField([
            'name' => 'faculty_id',
            'label' => "Facultad",
            'type' => 'select2',
            'entity' => 'faculty',
            'attribute' => 'name',
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              return $query->where('college_id', '=', 1)->orderBy('id', 'ASC')->get();
            })
          ]);
        }elseif (backpack_user()->type_user == 2) {
          $this->crud->addField([
          	'label' => 'Tipo de usuario',
          	'name' => 'type_user',
          	'type' => 'toggle',
          	'inline' => true,
          	'options' => [
              3 => 'Personal Interno de Reválidas y Equivalencias',
              4 => 'Solicitante'
          	],
          	'hide_when' => [
          		4 => ['faculty_id'],
              3 => ['faculty_id']
          		],
          	'default' => 4
          ]);
          //
          $this->crud->addField([
            'name' => 'faculty_id',
            'label' => "Facultad",
            'type' => 'select2',
            'entity' => 'faculty',
            'attribute' => 'name',
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              return $query->where('college_id', '=', 1)->orderBy('id', 'ASC')->get();
            }),
            'default' => backpack_user()->faculty_id
          ]);
        }else {
          $this->crud->addField(
          [
            'label' => 'Tipo de usuario',
            'name' => 'type_user',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
              4 => 'Solicitante'
            ],
            'hide_when' => [
              4 => ['faculty_id']
              ],
            'default' => 4
          ]);
        }

        $this->crud->setColumns([
          ['name' => 'ci', 'label' => 'Cédula', 'type' => 'text'],
          //
          ['name' => 'first_name', 'label' => 'Nombre', 'type' => 'text'],
          //
          ['name' => 'last_name', 'label' => 'Apellido', 'type' => 'text'],
          //
          ['name' => 'faculty_id',
            'label' => "Facultad",
            'type' => 'select',
            'entity' => 'faculty',
            'attribute' => 'name',
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
          //
          ['label' => 'Tipo de usuario',
            'name' => 'type_user',
            'type' => 'select_from_array',
            'options' => [
              1 => 'Super admin',
              2 => 'Personal Administrativo de Reválidas y Equivalencias',
              3 => 'Personal Interno de Reválidas y Equivalencias',
              4 => 'Solicitante'
            ]
          ],
          //
          ['name' => 'place_birth', 'label' => 'Lugar de Nacimiento', 'type' => 'text', 'visibleInTable' => false],
          //
          ['name' => 'nacionality',
            'label' => "Nacionalidad",
            'type' => 'select_from_array',
            'options' => ['v' => 'Venezolano', 'e' => 'Extranjero'],
            'visibleInTable' => false
          ],
          //
          ['name' => 'birthdate', 'label' => 'Fecha de nacimiento', 'type' => 'text', 'visibleInTable' => false],
          //
          ['name' => 'gender',
            'label' => "Genero",
            'type' => 'select_from_array',
            'options' => ['f' => 'Femenino', 'm' => 'Masculino'],
            'visibleInTable' => false
          ],
          //
          ['name' => 'address', 'label' => 'Dirección', 'type' => 'text', 'visibleInTable' => false],
          //
          ['name' => 'phone', 'label' => 'Teléfono', 'type' => 'text', 'visibleInTable' => false],
        ]);

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'ci',
            'label'=> 'Cédula'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'ci', '=', $value);
          }
        );

        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->addFilter([
                'type' => 'dropdown',
                'name' => 'type_user',
                'label'=> 'Tipo de usuario'
              ],
              [
                2 => 'Personal Administrativo de Reválidas y Equivalencias',
                3 => 'Personal Interno de Reválidas y Equivalencias',
                4 => 'Solicitante'
              ],
              function($value) {
                $this->crud->addClause('where', 'type_user', '=', $value);
              }
            );
            //
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
            break;
          case 2:
            $this->crud->addFilter([
                'type' => 'dropdown',
                'name' => 'type_user',
                'label'=> 'Tipo de usuario'
              ],
              [
                3 => 'Personal Interno de Reválidas y Equivalencias',
                4 => 'Solicitante'
              ],
              function($value) {
                $this->crud->addClause('where', 'type_user', '=', $value);
              }
            );
            break;
          default:
            break;
        }

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $request->request->set('password',Hash::make('1234567'));
        $facultyId = ($request->request->get('type_user') == 4) ? null : $request->request->get('faculty_id');
        $request->request->set('faculty_id',$facultyId);
        $redirect_location = parent::storeCrud($request);
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $facultyId = ($request->request->get('type_user') == 4) ? null : $request->request->get('faculty_id');
        $request->request->set('faculty_id',$facultyId);
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }
}
