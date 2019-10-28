<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VoucherRequestCreate as StoreRequest;
use App\Http\Requests\VoucherRequest as UpdateRequest;
use Illuminate\Support\Facades\DB;
use Backpack\CRUD\CrudPanel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Subject;
use App\Models\Career;
use App\Models\School;
use App\Models\Faculty;
use App\Models\College;
use App\Models\Voucher;

/**
 * Class VoucherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class VoucherCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Voucher');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/voucher');
        $this->crud->setEntityNameStrings('Comprobante', 'Comprobantes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->setEditView('editVoucher');
        $this->crud->addButtonFromView('line', '', 'botonGenerarPdfComprobante', 'bottom');

        $this->crud->denyAccess(['create', 'update', 'delete', 'list', 'show']);
        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->allowAccess(['list', 'update', 'show', 'delete']);
            break;
          case 2:
            $this->crud->allowAccess(['list', 'update', 'show' ]);
            break;
          case 3:
            $this->crud->allowAccess(['list', 'update','show']);
            break;
          default:
            break;
        }

        // $this->crud->addFields([
        //     ['name' => 'request_id',
        //       'label' => "Número de solicitud",
        //       'type' => 'select2',
        //       'entity' => 'request',
        //       'attribute' => 'data_request',
        //       'model' => "App\Models\Request",
        //       'options'   => (function ($query) {
        //           return $query->orderBy('id', 'ASC')->get();
        //       })
        //     ]
        // ], 'create');

        $this->crud->addFields([
            ['name' => 'request_id',
              'label' => "Número de solicitud",
              'type' => 'select2',
              'entity' => 'request',
              'attribute' => 'data_request',
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              }),
              'attributes' => ['disabled' => 'disabled']
            ],
            //
            ['name' => 'observations', 'label' => 'Observaciones', 'type'=>'textarea'],
            //
            ['name' => 'date_subcomi_eq', 'label' => 'Fecha Subcomisión de Equivalencias', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],
            //
            ['name' => 'date_comi_eq', 'label' => 'Fecha Comisión de Equivalencias', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],
            //
            ['name' => 'date_con_fac', 'label' => 'Fecha Consejo de Facultad', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],
            //
            ['name' => 'date_con_univ', 'label' => 'Fecha Consejo Universitario', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],
            //
            ['name' => 'ncu', 'label' => 'Nº CU', 'type'=>'text'],
            //
            ['name' => 'date_ncu', 'label' => 'Fecha Nº CU', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],
        ], 'update');

        $this->crud->setColumns([
            ['name' => 'id',
              'label' => 'Número de comprobante',
              'type'=>'text',
              'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('vouchers.id', 'like', '%'.$searchTerm.'%');
                },
            ],
            //
            ['name' => 'request_id',
              'label' => "Número de solicitud",
              'type' => 'select',
              'entity' => 'request',
              'attribute' => 'id',
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            //
            ['name' => 'user_ci',
              'label' => 'Cédula solicitante',
              'type'=>'text',
              'searchLogic' => function ($query, $column, $searchTerm) {
                  $query->orWhereHas('request', function ($q) use ($column, $searchTerm) {
                      $q->join('users', 'users.id', '=', 'requests.user_id')
                        ->where('users.ci', 'like', '%'.$searchTerm.'%');
                  });
              },
              'orderable' => true,
              'orderLogic' => function ($query, $column, $columnDirection) {
                  return $query->join('requests', 'requests.id', '=', 'vouchers.request_id')
                                ->join('users', 'users.id', '=', 'requests.user_id')
                                ->orderBy('users.ci', $columnDirection)->select('vouchers.*');
              }
            ],
            //
            ['name' => 'ncu', 'label' => 'Nº CU', 'type'=>'text'],
            //
            ['name' => 'career_origin_table',
              'label' => 'Carrera procedencia',
              'type'=>'text',
              'searchLogic' => function ($query, $column, $searchTerm) {
                  $query->orWhereHas('request', function ($q) use ($column, $searchTerm) {
                      $q->join('careers', 'careers.id', '=', 'requests.career_origin_id')
                        ->where('careers.name', 'like', '%'.$searchTerm.'%');
                  });
              },
              'orderable' => true,
              'orderLogic' => function ($query, $column, $columnDirection) {
                  return $query->join('requests', 'requests.id', '=', 'vouchers.request_id')
                                ->join('careers as o', 'o.id', '=', 'requests.career_origin_id')
                                ->orderBy('o.name', $columnDirection)->select('vouchers.*');
              },
              'limit'=>500
            ],
            //
            ['name' => 'career_destination_table',
              'label' => 'Carrera destino',
              'type'=>'text',
              'searchLogic' => function ($query, $column, $searchTerm) {
                  $query->orWhereHas('request', function ($q) use ($column, $searchTerm) {
                      $q->join('careers', 'careers.id', '=', 'requests.career_destination_id')
                        ->where('careers.name', 'like', '%'.$searchTerm.'%');
                  });
              },
              'orderable' => true,
              'orderLogic' => function ($query, $column, $columnDirection) {
                  return $query->join('requests', 'requests.id', '=', 'vouchers.request_id')
                                ->join('careers as d', 'd.id', '=', 'requests.career_destination_id')
                                ->orderBy('d.name', $columnDirection)->select('vouchers.*');
              },
              'limit'=>500
            ],
            //
            ['name' => 'date_subcomi_eq', 'label' => 'Fecha Subcomisión de Equivalencias', 'type'=>'date', 'visibleInTable' => false],
            //
            ['name' => 'date_comi_eq', 'label' => 'Fecha Comisión de Equivalencias', 'type'=>'date', 'visibleInTable' => false],
            //
            ['name' => 'date_con_fac', 'label' => 'Fecha Consejo de Facultad', 'type'=>'date', 'visibleInTable' => false],
            //
            ['name' => 'date_con_univ', 'label' => 'Fecha Consejo Universitario', 'type'=>'date', 'visibleInTable' => false],
            //
            ['name' => 'date_ncu', 'label' => 'Fecha Nº CU', 'type'=>'date', 'visibleInTable' => false],
            //
            ['name' => 'observations', 'label' => 'Observaciones', 'type'=>'text', 'visibleInTable' => false],
        ]);

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'id',
            'label'=> 'Número comprobante'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'vouchers.id', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'requestid',
            'label'=> 'Número solicitud'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'vouchers.request_id', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'userci',
            'label'=> 'Cédula'
          ],
          false,
          function($value) {
            $this->crud->query = $this->crud->query->select('vouchers.*')
                                                  ->join('requests as rfci', 'rfci.id', '=', 'vouchers.request_id')
                                                  ->join('users as ufci', 'ufci.id', '=', 'rfci.user_id')
                                                  ->where('ufci.ci', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'filterncu',
            'label'=> 'Nº CU'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'vouchers.ncu', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'college_origin_id',
            'label'=> 'Universidad procedencia',
            'placeholder' => 'Seleccione una Universidad'
          ],
          function(){
            return College::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
              $this->crud->query = $this->crud->query->select('vouchers.*')
                                                    ->join('requests as rfco', 'rfco.id', '=', 'vouchers.request_id')
                                                    ->join('careers as cfco', 'cfco.id', '=', 'rfco.career_origin_id')
                                                    ->join('schools as sfco', 'sfco.id', '=', 'cfco.school_id')
                                                    ->join('colleges as cofco', 'cofco.id', '=', 'sfco.college_id')
                                                    ->where('cofco.id', '=', $value);
          }
        );
        //
        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'college_destination_id',
            'label'=> 'Universidad destino',
            'placeholder' => 'Seleccione una Universidad'
          ],
          function(){
            return College::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
            $this->crud->query = $this->crud->query->select('vouchers.*')
                                                  ->join('requests as rfco', 'rfco.id', '=', 'vouchers.request_id')
                                                  ->join('careers as cfco', 'cfco.id', '=', 'rfco.career_destination_id')
                                                  ->join('schools as sfco', 'sfco.id', '=', 'cfco.school_id')
                                                  ->join('colleges as cofco', 'cofco.id', '=', 'sfco.college_id')
                                                  ->where('cofco.id', '=', $value);
          }
        );

        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }


    public function createVoucherFromRequest($id)
    {
      $currentVoucher = Voucher::where('request_id', $id)->first();
      if ($currentVoucher) {
        return 300;
      }
      $newVoucher = DB::insert('INSERT INTO vouchers (request_id, created_at) VALUES (?,NOW())', [$id]);
      return 200;
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

    public function getSubjectsDestination($id){
      $destinationSubject = DB::select('SELECT s.id , s.name
                                    FROM vouchers v
                                    JOIN requests r ON (r.id = v.request_id)
                                    JOIN careers co ON (co.id = r.career_destination_id)
                                    JOIN subjects s ON (s.career_id = co.id)
                                    WHERE v.id = ?
                                      AND s.id NOT IN (SELECT subject_id from equivalent_subjects WHERE voucher_id = ?)', [$id, $id]);
      return $destinationSubject;
    }

    public function createEquivalentSubject(Request $request)
    {
      $size = sizeof($request->values['approvedSubject']);
      for ($i=0; $i < $size; $i++) {
        $insertEquivalentSubjects = DB::insert('INSERT INTO equivalent_subjects VALUES (?,?,?,NOW(),NOW())'
                                    ,[NULL, (int)$request->voucher_id, (int)$request->values['approvedSubject'][$i]]);
      }
      return response()->json(['code_error' => 0 ]);
    }

    public function getEquivalentSubject($id){
      $equivalents = DB::select('SELECT ev.id id, s.id subjectId, s.name subjectName, s.code subjectCode, s.credits subjectsCredits
                            FROM equivalent_subjects ev
                            JOIN subjects s ON (s.id = ev.subject_id)
                            WHERE voucher_id = ?', [$id]);
      return $equivalents;
    }

    public function deleteEquivalentSubject(Request $request){
      $deleted = DB::delete('DELETE
                            FROM equivalent_subjects
                            WHERE id = ?', [(int)$request->record["id"]]);
      return $deleted;
    }

    public function generarPdfComprobante($id){
      set_time_limit(480);
      $dataDuplicates = ['SOLICITANTE', 'EXPEDIENTE', 'COMISIÓN REVÁLIDAS Y EQUIVALENCIAS FACULTAD', 'CONTROL DE ESTUDIOS CENTRAL'];
      $currentVoucher = Voucher::find($id);
      $equivalents = $currentVoucher->equivalent_subject;
      $numEquivalents = sizeof($equivalents);
      $numRegisters = 14;
      $numPag = (int)ceil($numEquivalents/$numRegisters);
      $numPag = $numPag == 0 ? 1 : $numPag;
      $views = "";
      $total = 0;

      if ($currentVoucher->request->career_destination->school->faculty) {
        $footer = DB::select('SELECT rep_sub_equi_one subComiOne, rep_sub_equi_two subComiTwo, rep_sub_equi_three subComiThree,
  	                         rep_comi_equi_one comiOne, rep_comi_equi_two comiTwo, rep_comi_equi_three comiThree,
                             dean decano
                             FROM academic_periods
                            WHERE faculty_id = ? AND deleted_at IS NULL
                            ORDER BY id DESC
                            LIMIT 1', [$currentVoucher->request->career_destination->school->faculty->id]);
      } else {
        $footer = [];
      }

      $total = 0;
      for ($i=0; $i < $numEquivalents; $i++) {
        $total += (int)$equivalents[$i]->subject->credits;
      }

      for ($j=0; $j < 1; $j++) {
        for ($i=0; $i < $numPag; $i++) {
          $paginateEquivalents = "";
          $paginateEquivalents = DB::select('SELECT s.name subjectName, s.code subjectCode, s.credits subjectCredits
                                              FROM subjects s
                                              JOIN equivalent_subjects es ON (es.subject_id = s.id)
                                              WHERE es.voucher_id = ?
                                              LIMIT 14 OFFSET ?', [$currentVoucher->id, (int)($i * $numRegisters)]);
           $views .= view('backpack::crud.pdf.generarPdfComprobante',
            ["currentVoucher"=> $currentVoucher, "numPag" => $i, "subjects" => $paginateEquivalents, 'totalCreditos' => $total, 'footer' => $footer, 'duplicates' => $dataDuplicates[$j]])->render();
           $paginateEquivalents = "";
        }
      }

      $pdf = PDF::loadHTML($views)->setPaper('Letter-L', 'landscape');
      return $pdf->stream();
    }
}
