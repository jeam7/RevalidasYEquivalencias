<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RequestRequest as StoreRequest;
use App\Http\Requests\RequestRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class RequestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class RequestCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Request');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/request');
        $this->crud->setEntityNameStrings('Solicitud', 'Solicitudes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addFields([
            ['name' => 'user_id', // the db column for the foreign key
              'label' => "Cedula solicitante",
              'type' => 'select2',
              'entity' => 'user', // the method that defines the relationship in your Model
              'attribute' => 'user_fullname', // foreign key attribute that is shown to user
              'model' => "App\Models\User",
              'options'   => (function ($query) {
                return $query->where('type_user','=', 4)->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'career_origin_id', // the db column for the foreign key
              'label' => "Carrera de procedencia",
              'type' => 'select2',
              'entity' => 'career_origin', // the method that defines the relationship in your Model
              'attribute' => 'career_school', // foreign key attribute that is shown to user
              'model' => "App\Models\Career",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'career_destination_id', // the db column for the foreign key
              'label' => "Carrera donde desea cursar",
              'type' => 'select2',
              'entity' => 'career_origin', // the method that defines the relationship in your Model
              'attribute' => 'career_school', // foreign key attribute that is shown to user
              'model' => "App\Models\Career",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            [
            	'label' => 'Procedencia de su universidad',
            	'name' => 'origin',
            	'type' => 'toggle',
            	'inline' => true,
            	'options' => [
                1 => 'Nacional',
                2 => 'Extranjera'
            	],
            	'hide_when' => [
            		1 => ['ci_passport_copy', 'notes_legalized', 'study_program_legalized', 'cerification_category_college', 'certification_title_no_confered', 'translation'],
                2 => ['others', 'info_others', 'pensum', 'notes', 'study_programs', 'title', 'copy_ci']
              ],
            	'default' => 1
            ],
            ['name' => 'others', 'label' => 'Otros documentos entregados', 'type' => 'checkbox'],
            ['name' => 'info_others', 'label' => 'Descripcion de otros documentos entregados', 'type' => 'textarea'],
            ['name' => 'pensum', 'label' => 'Pensum', 'type' => 'checkbox'],
            ['name' => 'notes', 'label' => 'Certificacion de notas (original)', 'type' => 'checkbox'],
            ['name' => 'study_programs', 'label' => 'Programas de estudios (autenticados)', 'type' => 'checkbox'],
            ['name' => 'title', 'label' => 'Si es egresado universitario, copia del titulo', 'type' => 'checkbox'],
            ['name' => 'copy_ci', 'label' => 'Fotocopia de la cedula de identidad', 'type' => 'checkbox'],
            ['name' => 'ci_passport_copy', 'label' => 'Cedula de identidad o pasaporte (fotocopia)', 'type' => 'checkbox'],
            ['name' => 'notes_legalized', 'label' => 'Certificacion de notas, legalizadas por las autoridades competentes (original y copia)', 'type' => 'checkbox'],
            ['name' => 'study_program_legalized', 'label' => 'Programas de estudios (originales, legalizados)', 'type' => 'checkbox'],
            ['name' => 'cerification_category_college', 'label' => 'Certificacion de la categoria universitaria del instituto de procedencia (oficialmente reconocida por las autoridades del pais de origen)', 'type' => 'checkbox'],
            ['name' => 'certification_title_no_confered', 'label' => 'Certificacion en donde conste que no le ha sido conferido el titulo correspondiente (En caso de haber aprobado todos los anos de estudio sin obtener el titulo)', 'type' => 'checkbox'],
            ['name' => 'translation', 'label' => 'Traduccion al castellano por interprete publico autorizado, en caso de estar la documentacion en idioma extranjero (original y fotocopia)', 'type' => 'checkbox']
        ]);

        // $this->crud->addField(
        // [
        // 	'label' => 'Procedencia de su universidad',
        // 	'name' => 'origin',
        // 	'type' => 'toggle',
        // 	'inline' => true,
        // 	'options' => [
        //     1 => 'Nacional',
        //     2 => 'Extranjera'
        // 	],
        // 	'hide_when' => [
        // 		1 => ['ci_passport_copy', 'notes_legalized', 'study_program_legalized', 'cerification_category_college', 'certification_title_no_confered', 'translation'],
        //     2 => ['others', 'info_others', 'pensum', 'notes', 'study_programs', 'title', 'copy_ci']
        //   ],
        // 	'default' => 1
        // ]);

        // //procedencia nacional
        // $this->crud->addField([
        //   'name' => 'others', 'label' => 'Otros documentos entregados', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'info_others', 'label' => 'Descripcion de otros documentos entregados', 'type' => 'textarea'
        // ]);
        // $this->crud->addField([
        //   'name' => 'pensum', 'label' => 'Pensum', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'notes', 'label' => 'Certificacion de notas (original)', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'study_programs', 'label' => 'Programas de estudios (autenticados)', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'title', 'label' => 'Si es egresado universitario, copia del titulo', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'copy_ci', 'label' => 'Fotocopia de la cedula de identidad', 'type' => 'checkbox'
        // ]);
        //
        // // procedencia extranjera
        // $this->crud->addField([
        //   'name' => 'ci_passport_copy', 'label' => 'Cedula de identidad o pasaporte (fotocopia)', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'notes_legalized', 'label' => 'Certificacion de notas, legalizadas por las autoridades competentes (original y copia)', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'study_program_legalized', 'label' => 'Programas de estudios (originales, legalizados)', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'cerification_category_college', 'label' => 'Certificacion de la categoria universitaria del instituto de procedencia (oficialmente reconocida por las autoridades del pais de origen)', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'certification_title_no_confered', 'label' => 'Certificacion en donde conste que no le ha sido conferido el titulo correspondiente (En caso de haber aprobado todos los anos de estudio sin obtener el titulo)', 'type' => 'checkbox'
        // ]);
        // $this->crud->addField([
        //   'name' => 'translation', 'label' => 'Traduccion al castellano por interprete publico autorizado, en caso de estar la documentacion en idioma extranjero (original y fotocopia)', 'type' => 'checkbox'
        // ]);

        //
        // $this->crud->setColumns([
        //   ['name' => 'ci', 'label' => 'Cedula', 'type' => 'text'],
        //   ['name' => 'first_name', 'label' => 'Nombre', 'type' => 'text'],
        //   ['name' => 'last_name', 'label' => 'Apellido', 'type' => 'text'],
        //   ['name' => 'faculty_id', // the db column for the foreign key
        //     'label' => "Facultad",
        //     'type' => 'select',
        //     'entity' => 'faculty', // the method that defines the relationship in your Model
        //     'attribute' => 'faculty_college', // foreign key attribute that is shown to user
        //     'model' => "App\Models\Faculty",
        //     'options'   => (function ($query) {
        //       return $query->orderBy('id', 'ASC')->get();
        //     })
        //   ],
        //   ['label' => 'Tipo de usuario',
        //     'name' => 'type_user',
        //     'type' => 'select_from_array',
        //     'options' => [
        //       1 => 'Super admin',
        //       2 => 'Personal administrativo de revalidas y equivalencias',
        //       3 => 'Personal interno de revalidas y equivalencias',
        //       4 => 'Solicitante'
        //     ]
        //   ],
        //   ['name' => 'place_birth', 'label' => 'Lugar de Nacimiento', 'type' => 'text', 'visibleInTable' => false],
        //   ['name' => 'nacionality',
        //     'label' => "Nacionalidad",
        //     'type' => 'select_from_array',
        //     'options' => ['v' => 'Venezolano', 'e' => 'Extranjero'],
        //     'visibleInTable' => false
        //   ],
        //   ['name' => 'birthdate', 'label' => 'Fecha de nacimiento', 'type' => 'text', 'visibleInTable' => false],
        //   ['name' => 'gender',
        //     'label' => "Genero",
        //     'type' => 'select_from_array',
        //     'options' => ['f' => 'Femenino', 'm' => 'Masculino'],
        //     'visibleInTable' => false
        //   ],
        //   ['name' => 'address', 'label' => 'Direccion', 'type' => 'text', 'visibleInTable' => false],
        //   ['name' => 'phone', 'label' => 'Telefono', 'type' => 'text', 'visibleInTable' => false],
        // ]);
        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in RequestRequest
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
