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
            $this->crud->allowAccess(['create', 'list', 'update', 'delete', 'show']);
            break;
          case 2:
            $this->crud->allowAccess(['create', 'list', 'update', 'show' ]);
            $this->crud->addClause('VoucherByFaculty', backpack_user()->faculty_id);
            break;
          case 3:
            $this->crud->allowAccess(['create', 'list', 'show']);
            $this->crud->addClause('VoucherByFaculty', backpack_user()->faculty_id);
            break;
          default:
            break;
        }

        $this->crud->addFields([
            ['name' => 'request_id',
              'label' => "Numero de solicitud",
              'type' => 'select2',
              'entity' => 'request',
              'attribute' => 'data_request',
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                if (backpack_user()->type_user == 3) {
                  return $query->join('careers', 'careers.id', '=', 'requests.career_destination_id')
                                      ->join('schools', 'schools.id', '=', 'careers.school_id')
                                      ->where('schools.faculty_id', '=', backpack_user()->faculty_id)
                                      ->orderBy('requests.id', 'ASC')
                                      ->get();
                }else {
                  return $query->orderBy('id', 'ASC')->get();
                }
              })
            ]
        ], 'create');

        $this->crud->addFields([
            ['name' => 'request_id',
              'label' => "Numero de solicitud",
              'type' => 'select2',
              'entity' => 'request',
              'attribute' => 'data_request',
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              }),
              'attributes' => ['disabled' => 'disabled']
            ],
            ['name' => 'observations', 'label' => 'Observaciones', 'type'=>'textarea'],
            ['name' => 'date_subcomi_eq', 'label' => 'Fecha subcomision de equivalencias', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],
            ['name' => 'date_comi_eq', 'label' => 'Fecha comision de equivalencias', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],

            ['name' => 'date_con_fac', 'label' => 'Fecha consejo de facultad', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ],

            ['name' => 'date_con_univ', 'label' => 'Fecha consejo universitario', 'type'=>'date_picker',
            'date_picker_options' => [
              'todayBtn' => 'linked',
              'format' => 'yyyy-mm-dd',
              'language' => 'es'
              ]
            ]
        ], 'update');

        $this->crud->setColumns([
            ['name' => 'id',
              'label' => 'Numero de comprobante',
              'type'=>'text',
              'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('vouchers.id', 'like', '%'.$searchTerm.'%');
                },
            ],
            ['name' => 'request_id',
              'label' => "Numero de solicitud",
              'type' => 'select',
              'entity' => 'request',
              'attribute' => 'id',
              'model' => "App\Models\Request",
              'options'   => (function ($query) {
                return $query->orderBy('id', 'ASC')->get();
              })
            ],
            ['name' => 'user_ci',
              'label' => 'Cedula solicitante',
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
            ['name' => 'career_origin_table',
              'label' => 'Universidad - Carrera (Procedencia)',
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
            ['name' => 'career_destination_table',
              'label' => 'Universidad - Carrera (Destino)',
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
            ['name' => 'date_subcomi_eq', 'label' => 'Fecha subcomision de equivalencias', 'type'=>'date', 'visibleInTable' => false],
            ['name' => 'date_comi_eq', 'label' => 'Fecha comision de equivalencias', 'type'=>'date', 'visibleInTable' => false],
            ['name' => 'date_con_fac', 'label' => 'Fecha consejo de facultad', 'type'=>'date', 'visibleInTable' => false],
            ['name' => 'date_con_univ', 'label' => 'Fecha consejo universitario', 'type'=>'date', 'visibleInTable' => false]
        ]);

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'id',
            'label'=> 'Numero comprobante'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'vouchers.id', '=', $value);
          }
        );

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'requestid',
            'label'=> 'Numero solicitud'
          ],
          false,
          function($value) {
            $this->crud->addClause('where', 'vouchers.request_id', '=', $value);
          }
        );

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'userci',
            'label'=> 'Cedula'
          ],
          false,
          function($value) {
            $this->crud->query = $this->crud->query->select('vouchers.*')
                                                  ->join('requests as rfci', 'rfci.id', '=', 'vouchers.request_id')
                                                  ->join('users as ufci', 'ufci.id', '=', 'rfci.user_id')
                                                  ->where('ufci.ci', '=', $value);
          }
        );

        $this->crud->addFilter([
            'type' => 'select2',
            'name' => 'careerorigin',
            'label'=> 'Carrera procedencia'
          ],
          function(){
            return \App\Models\Career::all()->pluck('name', 'id')->toArray();
          },
          function($value) {
            $this->crud->query = $this->crud->query->select('vouchers.*')
                                                  ->join('requests as rfco', 'rfco.id', '=', 'vouchers.request_id')
                                                  ->join('careers as cfco', 'cfco.id', '=', 'rfco.career_origin_id')
                                                  ->where('cfco.id', '=', $value);
          }
        );

        switch (backpack_user()->type_user) {
          case 1:
            $this->crud->addFilter([
                'type' => 'select2',
                'name' => 'careerdestination',
                'label'=> 'Carrera destino'
              ],
              function(){
                return \App\Models\Career::all()->pluck('name', 'id')->toArray();
              },
              function($value) {
                $this->crud->query = $this->crud->query->select('vouchers.*')
                                                      ->join('requests as rfcd', 'rfcd.id', '=', 'vouchers.request_id')
                                                      ->join('careers as cfcoa', 'cfcoa.id', '=', 'rfcd.career_destination_id')
                                                      ->where('cfcoa.id', '=', $value);
              }
            );
            break;
          case 2:
            $this->crud->addFilter([
                'type' => 'select2',
                'name' => 'careerdestination',
                'label'=> 'Carrera destino'
              ],
              function(){
                return \App\Models\Career::careersByFaculty(backpack_user()->faculty_id)->pluck('careers.name', 'careers.id')->toArray();
              },
              function($value) {
                // $this->crud->query = $this->crud->query->select('vouchers.*')
                //                                       ->join('requests', 'requests.id', '=', 'vouchers.request_id')
                //                                       ->join('careers', 'careers.id', '=', 'requests.career_destination_id')
                //                                       ->where('careers.id', '=', $value);
                $this->crud->query = $this->crud->query->select('vouchers.*')
                                                      ->join('requests as rfcd', 'rfcd.id', '=', 'vouchers.request_id')
                                                      ->join('careers as cfcoa', 'cfcoa.id', '=', 'rfcd.career_destination_id')
                                                      ->where('cfcoa.id', '=', $value);
              }
            );
            break;
          case 3:
            $this->crud->addFilter([
                'type' => 'select2',
                'name' => 'careerdestination',
                'label'=> 'Carrera destino'
              ],
              function(){
                return \App\Models\Career::careersByFaculty(backpack_user()->faculty_id)->pluck('careers.name', 'careers.id')->toArray();
              },
              function($value) {
                // $this->crud->query = $this->crud->query->select('vouchers.*')
                //                                       ->join('requests', 'requests.id', '=', 'vouchers.request_id')
                //                                       ->join('careers', 'careers.id', '=', 'requests.career_destination_id')
                //                                       ->where('careers.id', '=', $value);
                $this->crud->query = $this->crud->query->select('vouchers.*')
                                                      ->join('requests as rfcd', 'rfcd.id', '=', 'vouchers.request_id')
                                                      ->join('careers as cfcoa', 'cfcoa.id', '=', 'rfcd.career_destination_id')
                                                      ->where('cfcoa.id', '=', $value);
              }
            );
            break;
          default:
            break;
        }

        // add asterisk for fields that are required in VoucherRequest
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

    public function getSubjectsOrigin($id){
      $originSubjects = DB::select('SELECT s.id subjectId, s.name subjectName
                                    FROM vouchers v
                                    JOIN requests r ON (r.id = v.id)
                                    JOIN careers co ON (co.id = r.career_origin_id)
                                    JOIN subjects s ON (s.career_id = co.id)
                                    WHERE v.id = ?', [$id]);
      return $originSubjects;
    }

    public function getSubjectsDestination($id){
      $originSubjects = DB::select('SELECT s.id subjectId, s.name subjectName
                                    FROM vouchers v
                                    JOIN requests r ON (r.id = v.id)
                                    JOIN careers co ON (co.id = r.career_destination_id)
                                    JOIN subjects s ON (s.career_id = co.id)
                                    WHERE v.id = ?
                                      AND s.id NOT IN (SELECT subject_a_id from equivalent_subjects WHERE voucher_id = ?)', [$id, $id]);
      return $originSubjects;
    }

    public function createEquivalentSubject(Request $request)
    {
      $size = sizeof($request->values['equivalentsSubjects']);
      for ($i=0; $i < $size; $i++) {
        $insertEquivalentSubjects = DB::insert('INSERT INTO equivalent_subjects VALUES (?,?,?,?,NOW(),NOW())'
                                    ,[NULL, (int)$request->voucher_id, (int)$request->values['approvedSubject'], (int)$request->values['equivalentsSubjects'][$i]]);
      }

      return response()->json(['code_error' => 0 ]);
    }

    public function getEquivalentSubject($id){
      $skip = DB::select('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"');
      $equivalents = DB::select('SELECT es.id id, es.voucher_id voucherId, s.id subjectId, s.name subjectName, s.credits subjectsCredits,
			                           group_concat(s2.code SEPARATOR ",") subjectEquivalentId, group_concat(s2.name SEPARATOR ",") subjectEquivalentName
                                 FROM equivalent_subjects es
                                 JOIN subjects s ON (s.id = es.subject_a_id)
                                 JOIN subjects s2 ON (s2.id = es.subject_e_id)
                                 WHERE es.voucher_id = ?
                                 GROUP BY es.subject_a_id', [$id]);
      return $equivalents;
    }

    public function deleteEquivalentSubject(Request $request){
      $voucherId = (int)$request->record["voucherId"];
      $equivalentId = (int)$request->record["subjectId"];

      $deleted = DB::delete('DELETE
                            FROM equivalent_subjects
                            WHERE voucher_id = ? AND subject_a_id = ?', [$voucherId, $equivalentId]);
      return $deleted;
    }

    public function generarPdfComprobante($id){
      set_time_limit(480);
      // $dataDuplicates = ['ORIGINAL EXPEDIENTE', 'DUPLICADO SOLICITANTE', 'TRIPLICADO SECRETARIA DEL CONSEJO UNIVERSITARIO',
      //                     'CUADRUPLICADO CONTROL DE ESTUDIOS CENTRAL', 'QUINTUPLICADO FACULTAD (COMISION DE EQUIVALENCIAS)',
      //                     'SEXTUPLICADO FACULTAD (SUBCOMISION DE EQUIVALENCIA)'];

      $dataDuplicates = ['ORIGINAL EXPEDIENTE'];

      $dataVoucher = Voucher::find($id);

      $skip = DB::select('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"');

      $equivalents = DB::select('SELECT es.id id, es.voucher_id voucherId, s.id subjectId, s.name subjectName, s.credits subjectsCredits,
                                 group_concat(s2.code SEPARATOR ",") subjectEquivalentId, group_concat(s2.name SEPARATOR ",") subjectEquivalentName
                                 FROM equivalent_subjects es
                                 JOIN subjects s ON (s.id = es.subject_a_id)
                                 JOIN subjects s2 ON (s2.id = es.subject_e_id)
                                 WHERE es.voucher_id = ?
                                 GROUP BY es.subject_a_id', [$id]);

      $numEquivalents = sizeof($equivalents);
      $numRegisters = 5;
      $numPag = (int)ceil($numEquivalents/$numRegisters);
      $numPag = $numPag == 0 ? 1 : $numPag;
      $views = "";
      $total = 0;

      if ($dataVoucher->request->career_destination) {
        $footer = DB::select('SELECT rep_sub_equi_one subComiOne, rep_sub_equi_two subComiTwo, rep_sub_equi_three subComiThree,
  	                         rep_comi_equi_one comiOne, rep_comi_equi_two comiTwo, rep_comi_equi_three comiThree,
                             dean decano
                             FROM academic_periods
                            WHERE faculty_id = 3 AND deleted_at IS NULL
                            ORDER BY id DESC
                            LIMIT 1', [$dataVoucher->request->career_destination->school->faculty->id]);
      } else {
        $footer = [];
      }



      for ($i=0; $i < $numEquivalents; $i++) {
        $total += (int)$equivalents[$i]->subjectsCredits;
      }

      // $facultyDestination = $dataVoucher->request->career_destination->school->faculty ? $dataVoucher->request->career_destination->school->faculty->name : "";
      // $schoolDestination = $dataVoucher->request->career_destination->school ? $dataVoucher->request->career_destination->school->name : "";
      // $collegeDestination = $dataVoucher->request->career_destination->school->faculty->college ? $dataVoucher->request->career_destination->school->faculty->college->name : "";
      // $lastName = $dataVoucher->request->user ? $dataVoucher->request->user->last_name : "";
      // $firstName = $dataVoucher->request->user ? $dataVoucher->request->user->first_name : "";
      // $ci = $dataVoucher->request->user ? strtoupper($dataVoucher->request->user->nacionality) . " - " . $dataVoucher->request->user->ci : "";
      // $requestId = $dataVoucher->request ? $dataVoucher->request->id : "";
      // $facultyOrigin = $dataVoucher->request->career_origin->school->faculty ? $dataVoucher->request->career_origin->school->faculty->name : "";
      // $schoolOrigin = $dataVoucher->request->career_origin->school ? $dataVoucher->request->career_origin->school->name : "";
      // $collegeOrigin = $dataVoucher->request->career_origin->school->faculty->college ? $dataVoucher->request->career_origin->school->faculty->college->name : "";
      // $footer = sizeof($footer) > 0 ? $footer[0] : [];
      // $dateSubComi = $dataVoucher->date_subcomi_eq ? $dataVoucher->date_subcomi_eq : "";
      // $dateComi = $dataVoucher->date_comi_eq ? $dataVoucher->date_comi_eq : "";
      // $dateConFac = $dataVoucher->date_con_fac ? $dataVoucher->date_con_fac : "";
      // $dateUniv = $dataVoucher->date_con_univ ? $dataVoucher->date_con_univ : "";
      // $observations = $dataVoucher->observations ? $dataVoucher->observations : "Sin observaciones";

      $facultyDestination = $dataVoucher->request->career_destination ? $dataVoucher->request->career_destination->school->faculty->name : "";
      $schoolDestination = $dataVoucher->request->career_destination ? $dataVoucher->request->career_destination->school->name : "";
      $collegeDestination = $dataVoucher->request->career_destination ? $dataVoucher->request->career_destination->school->faculty->college->name : "";
      $lastName = $dataVoucher->request->user ? $dataVoucher->request->user->last_name : "";
      $firstName = $dataVoucher->request->user ? $dataVoucher->request->user->first_name : "";
      $ci = $dataVoucher->request->user ? strtoupper($dataVoucher->request->user->nacionality) . " - " . $dataVoucher->request->user->ci : "";
      $requestId = $dataVoucher->request ? $dataVoucher->request->id : "";
      $facultyOrigin = $dataVoucher->request->career_origin ? $dataVoucher->request->career_origin->school->faculty->name : "";
      $schoolOrigin = $dataVoucher->request->career_origin ? $dataVoucher->request->career_origin->school->name : "";
      $collegeOrigin = $dataVoucher->request->career_origin ? $dataVoucher->request->career_origin->school->faculty->college->name : "";
      $footer = sizeof($footer) > 0 ? $footer[0] : [];
      $dateSubComi = $dataVoucher->date_subcomi_eq ? $dataVoucher->date_subcomi_eq : "";
      $dateComi = $dataVoucher->date_comi_eq ? $dataVoucher->date_comi_eq : "";
      $dateConFac = $dataVoucher->date_con_fac ? $dataVoucher->date_con_fac : "";
      $dateUniv = $dataVoucher->date_con_univ ? $dataVoucher->date_con_univ : "";
      $observations = $dataVoucher->observations ? $dataVoucher->observations : "Sin observaciones";

      for ($j=0; $j < sizeof($dataDuplicates); $j++) {
        for ($i=0; $i < $numPag; $i++) {
          $equivalents = DB::select('SELECT es.id id, es.voucher_id voucherId, s.id subjectId, s.name subjectName, s.credits subjectsCredits,
                                     group_concat(s2.code SEPARATOR ",") subjectEquivalentId, group_concat(s2.name SEPARATOR ",") subjectEquivalentName
                                     FROM equivalent_subjects es
                                     JOIN subjects s ON (s.id = es.subject_a_id)
                                     JOIN subjects s2 ON (s2.id = es.subject_e_id)
                                     WHERE es.voucher_id = ?
                                     GROUP BY es.subject_a_id
                                     LIMIT ? OFFSET ?', [$id, $numRegisters, ($i * $numRegisters)]);

          $equivalents = sizeof($equivalents) > 0 ? $equivalents : [];
           $views .= view('backpack::crud.pdf.generarPdfComprobante',
               ["voucherId"=> $id,
               "facultyDestination"=> $facultyDestination, "schoolDestination" => $schoolDestination, "collegeDestination" => $collegeDestination, "numPag" => ($i + 1),
               "lastName" => $lastName, "firstName" => $firstName, "ci" => $ci, "requestId" => $requestId,
               "facultyOrigin"=> $facultyOrigin, "schoolOrigin" => $schoolOrigin, "collegeOrigin" => $collegeOrigin,
               "equivalents" => $equivalents,
               "total" => $total,
               "footer" => $footer,
               "dateSubComi" => $dateSubComi, "dateComi" => $dateComi, "dateConFac" => $dateConFac, "dateUniv" => $dateUniv,
               "duplicates"=> $dataDuplicates[$j]])->render();
        }
      }

      $views .= view('backpack::crud.pdf.generarPdfComprobanteObs',
      ["voucherId"=> $id,
      "observations" => $observations,
      "footer" => $footer,
      "dateSubComi" => $dateSubComi, "dateComi" => $dateComi, "dateConFac" => $dateConFac, "dateUniv" => $dateUniv,
      "duplicates"=> $dataDuplicates[0]
      ]
      )->render();

      $pdf = PDF::loadHTML($views)->setPaper('Letter-L', 'landscape');
      return $pdf->stream();
    }
}
