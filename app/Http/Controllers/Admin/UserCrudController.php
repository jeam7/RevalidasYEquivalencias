<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
        if(backpack_user()->type_user == 1) {
          $this->crud->allowAccess(['create', 'update', 'list', 'delete', 'show']);
        }elseif (backpack_user()->type_user == 2) {
          $this->crud->allowAccess(['create', 'update', 'list', 'delete', 'show']);
          $this->crud->addClause('myFaculty', backpack_user()->faculty_id);
        }elseif (backpack_user()->type_user == 3) {
          $this->crud->allowAccess(['create', 'update', 'list', 'show']);
          $this->crud->addClause('where', 'type_user', '=', 4);
        }

        $this->crud->allowAccess('show');
        $this->crud->addFields([
          ['name'=>'ci', 'label'=>'Cedula', 'type'=>'text'],
          ['name'=>'first_name', 'label'=>'Nombre', 'type'=>'text'],
          ['name'=>'last_name', 'label'=>'Apellido', 'type'=>'text'],
          ['name'=>'place_birth', 'label'=>'Lugar de nacimiento', 'type'=>'text'],
          ['name' => 'nacionality',
            'label' => "Nacionalidad",
            'type' => 'select_from_array',
            'options' => ['v' => 'Venezolano', 'e' => 'Extranjero']
          ],
          ['name'=>'birthdate', 'label'=>'Fecha de nacimiento', 'type'=>'date'],
          ['name' => 'gender',
            'label' => "Genero",
            'type' => 'select_from_array',
            'options' => ['f' => 'Femenino', 'm' => 'Masculino']
          ],
          ['name'=>'address', 'label'=>'Direccion', 'type'=>'textarea'],
          ['name'=>'phone', 'label'=>'Telefono', 'type'=>'text'],
          ['name'=>'email', 'label'=>'Email', 'type'=>'email'],
        ]);


        if (backpack_user()->type_user == 1) {
          $this->crud->addField(
          [
            'label' => 'Tipo de usuario',
            'name' => 'type_user',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
              2 => 'Personal administrativo de revalidas y equivalencias',
              3 => 'Personal interno de revalidas y equivalencias',
              4 => 'Solicitante'
            ],
            'hide_when' => [
              4 => ['faculty_id'],
              ],
            'default' => 4
          ]);
          $this->crud->addField([
            'name' => 'faculty_id', // the db column for the foreign key
            'label' => "Facultad",
            'type' => 'select2',
            'entity' => 'faculty', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              return $query->where('college_id', '=', 1)->orderBy('id', 'ASC')->get();
            })
          ]);
        }elseif (backpack_user()->type_user == 2) {
          $this->crud->addField(
          [
          	'label' => 'Tipo de usuario',
          	'name' => 'type_user',
          	'type' => 'toggle',
          	'inline' => true,
          	'options' => [
              3 => 'Personal interno de revalidas y equivalencias',
              4 => 'Solicitante'
          	],
          	'hide_when' => [
          		4 => ['faculty_id'],
              3 => ['faculty_id']
          		],
          	'default' => 4
          ]);
          $this->crud->addField([
            'name' => 'faculty_id', // the db column for the foreign key
            'label' => "Facultad",
            'type' => 'select2',
            'entity' => 'faculty', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
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
          ['name' => 'ci', 'label' => 'Cedula', 'type' => 'text'],
          ['name' => 'first_name', 'label' => 'Nombre', 'type' => 'text'],
          ['name' => 'last_name', 'label' => 'Apellido', 'type' => 'text'],
          ['name' => 'faculty_id', // the db column for the foreign key
            'label' => "Facultad",
            'type' => 'select',
            'entity' => 'faculty', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Faculty",
            'options'   => (function ($query) {
              return $query->orderBy('id', 'ASC')->get();
            })
          ],
          ['label' => 'Tipo de usuario',
            'name' => 'type_user',
            'type' => 'select_from_array',
            'options' => [
              1 => 'Super admin',
              2 => 'Personal administrativo de revalidas y equivalencias',
              3 => 'Personal interno de revalidas y equivalencias',
              4 => 'Solicitante'
            ]
          ],
          ['name' => 'place_birth', 'label' => 'Lugar de Nacimiento', 'type' => 'text', 'visibleInTable' => false],
          ['name' => 'nacionality',
            'label' => "Nacionalidad",
            'type' => 'select_from_array',
            'options' => ['v' => 'Venezolano', 'e' => 'Extranjero'],
            'visibleInTable' => false
          ],
          ['name' => 'birthdate', 'label' => 'Fecha de nacimiento', 'type' => 'text', 'visibleInTable' => false],
          ['name' => 'gender',
            'label' => "Genero",
            'type' => 'select_from_array',
            'options' => ['f' => 'Femenino', 'm' => 'Masculino'],
            'visibleInTable' => false
          ],
          ['name' => 'address', 'label' => 'Direccion', 'type' => 'text', 'visibleInTable' => false],
          ['name' => 'phone', 'label' => 'Telefono', 'type' => 'text', 'visibleInTable' => false],
        ]);

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in UserRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $request->request->set('password',Hash::make('1234567'));
        $facultyId = ($request->request->get('type_user') == 4) ? null : $request->request->get('faculty_id');
        $request->request->set('faculty_id',$facultyId);
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $facultyId = ($request->request->get('type_user') == 4) ? null : $request->request->get('faculty_id');
        $request->request->set('faculty_id',$facultyId);
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
