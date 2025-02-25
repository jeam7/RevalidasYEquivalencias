    <style>
        @page { margin: 30px 30px 20px 30px;}
       /* header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; }
       footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; } */
        /* p { page-break-after: always; }
       p:last-child { page-break-after: never; } */
       /* p {
         text-align: justify;
         text-justify: inter-word;
       } */
       span{
         font-size: 14px;
       }
       body{
         font-family: "calibri";
       }
       .idSolicitud{
         position: absolute;
         top: 10;
         left: 650;
       }
       .font-10{
         font-size: 10px;
       }
       .font-12{
         font-size: 12px;
       }
       table {
         border-collapse: collapse;
         width: 100%;
       }
       td {
         border: 1px solid black;
         text-align: left;
       }
        #watermark {
          position: fixed;
          bottom: 35%;
          left: 35%;
          width: 280px;
          height: 280px;
          z-index: -1000;
          opacity: 0.1;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{asset("css/cssPdf.css")}}">
  <div class="page-break">


    <div class="border border-dark">
      <div id="watermark">
          <img src="images/logoUCV.png" height="100%" width="100%" />
      </div>
      <div class="">
            <p class="font-weight-bold m-1 mt-2 font-10">UNIVERSIDAD CENTRAL DE VENEZUELA</p>
            <p class="font-weight-bold m-1 font-10">CONSEJO UNIVERSITARIO</p>
            <p class="font-weight-bold m-1 font-10">SECRETARIA</p>
          <h6 class="idSolicitud">No. <span style="color:red; font-size:18px;">
            {{$currentVoucher->id}}
          </span></h6>
          <center>
            <h6> COMPROBANTE DE ASIGNATURAS EQUIVALENTES </h6>
          </center>
      </div>

      <table>
        <tr>
          <td class="border-left-0" width="200">
            <center><p class="font-10 m-0">FACULTAD DONDE DESEA CURSAR</p></center>
          </td>
          <td class="border-left-0" width="160">
            <center><p class="font-10 m-0">ESCUELA O ESPECIALIDAD</p></center>
          </td>
          <td class="border-left-0" width="160">
            <center><p class="font-10 m-0">UNIVERSIDAD O INSTITUTO DONDE DESEA CURSAR</p></center>
          </td>
          <td class="border-left-0" width="100">
            <center><p class="font-10 m-0">PAG.</p></center>
          </td>
        </tr>

        <tr>
          <td class="border-left-0"  width="200">
            <p class="mt-0 ml-3 mb-0 mr-0 font-10">
              {{ $currentVoucher->request->career_destination->school->faculty ?  $currentVoucher->request->career_destination->school->faculty->name : ""}}
            </p>
          </td>
          <td class="border-left-0" width="160">
            <p class="mt-0 ml-3 mb-0 mr-0 font-10">
              {{ $currentVoucher->request->career_destination->school ?  $currentVoucher->request->career_destination->school->name : ""}}
            </p>
          </td>
          <td class="border-left-0 ml-3" width="160">
            <p class="font-10 m-0">{{ $currentVoucher->request->career_destination->school->college ?  $currentVoucher->request->career_destination->school->college->name : ""}}</p>
          </td>
          <td class="border-left-0" width="60">
            <p class="mt-0 ml-3 mb-0 mr-0 font-10"> {{ $numPag+1 }} </p>
          </td>
        </tr>

        <tr>
          <td class="border-left-0" width="200">
            <center><p class="font-10 m-0">APELLIDO(S)</p></center>
          </td>
          <td class="border-left-0" width="160">
            <center><p class="font-10 m-0">NOMBRE(S)</p></center>
          </td>
          <td class="border-left-0" width="160">
            <center><p class="font-10 m-0">CEDULA DE IDENTIDAD</p></center>
          </td>
          <td class="border-left-0" width="60">
            <center><p class="font-10 m-0">No. DE LA SOLICITUD</p></center>
          </td>
        </tr>

        <tr>
          <td class="border-left-0 ml-3"  width="200">
            <p class="font-10 m-0"> {{ $currentVoucher->request->user ?  $currentVoucher->request->user->last_name : ""}}</p>
          </td>
          <td class="border-left-0 ml-3" width="160">
            <p class="font-10 m-0"> {{ $currentVoucher->request->user ?  $currentVoucher->request->user->first_name : ""}}</p>
          </td>
          <td class="border-left-0 ml-3" width="160">
            <p class="font-10 m-0"> {{ $currentVoucher->request->user ?  $currentVoucher->request->user->ci : ""}}</p>
          </td>
          <td class="border-left-0 ml-3" width="60">
            <p class="font-10 m-0"> {{ $currentVoucher->request ?  $currentVoucher->request->id : ""}}</p>
          </td>
        </tr>

        <tr>
          <td class="border-left-0" width="200">
            <center><p class="font-10 m-0">FACULTAD DONDE CURSABA ANTERIORMENTE</p></center>
          </td>
          <td class="border-left-0">
            <center><p class="font-10 m-0">ESCUELA O ESPECIALIDAD</p></center>
          </td>
          <td colspan="2" class="border-left-0">
            <center><p class="font-10 m-0">UNIVERSIDAD DE PROCEDENCIA</p></center>
          </td>
        </tr>

        <tr>
          <td class="border-left-0"  width="200">
            <p class="mt-0 ml-3 mb-0 mr-0 font-10">
              {{ $currentVoucher->request->career_origin->school->faculty ?  $currentVoucher->request->career_origin->school->faculty->name : ""}}
            </p>
          </td>
          <td class="border-left-0"  width="160">
            <p class="mt-0 ml-3 mb-0 mr-0 font-10">
              {{ $currentVoucher->request->career_origin->school ?  $currentVoucher->request->career_origin->school->name : ""}}
            </p>
          </td>
          <td class="border-left-0"  width="160" colspan="2">
            <p class="mt-0 ml-3 mb-0 mr-0 font-10">
              {{ $currentVoucher->request->career_origin->school->college ?  $currentVoucher->request->career_origin->school->college->name : ""}}
            </p>
          </td>
        </tr>
      </table>
      <br>
      <table>
        <tr>
          <td class="border-left-0" width="200">
            <center><p class="font-10 m-0">ASIGNATURAS EQUIVALENTES</p></center>
          </td>
          <td class="border-left-0" width="100">
            <center><p class="font-10 m-0">CÓDIGO DE MATERIAS</p></center>
          </td>
          <td class="border-left-0" width="50">
            <center><p class="font-10 m-0">UNIDADES DE CREDITO</p></center>
          </td>

          <td class="border-left-0" width="200">
            <center><p class="font-10 m-0">ASIGNATURAS EQUIVALENTES</p></center>
          </td>
          <td class="border-left-0" width="100">
            <center><p class="font-10 m-0" >CÓDIGO DE MATERIAS</p></center>
          </td>
          <td class="border-left-0" width="50">
            <center><p class="font-10 m-0">UNIDADES DE CREDITO</p></center>
          </td>
        </tr>

        @for ($i=0; $i < 14; $i=$i+2)
            <tr>
                <td class="border-left-0" width="200">
                  <p class="font-10 m-0 ml-3 {{$i >= sizeof($subjects) ? 'text-white' : ''}}">{{  ($i >= sizeof($subjects) ? "xxx" : $subjects[$i]->subjectName) }}</p>
                </td>
                <td class="border-left-0" width="100">
                  <center><p class="font-10 m-0 {{$i >= sizeof($subjects) ? 'text-white' : ''}}">{{  ($i >= sizeof($subjects) ? "xxx" : $subjects[$i]->subjectCode) }}</p></center>
                </td>
                <td class="border-left-0" width="50">
                  <center><p class="font-10 m-0 {{$i >= sizeof($subjects) ? 'text-white' : ''}}">{{  ($i >= sizeof($subjects) ? "xxx" : $subjects[$i]->subjectCredits) }}</p></center>
                </td>

                <td class="border-left-0" width="200">
                  <p class="font-10 m-0 ml-3 {{$i+1 >= sizeof($subjects) ? 'text-white' : ''}}">{{  ($i+1 >= sizeof($subjects) ? "xxx" : $subjects[$i+1]->subjectName) }}</p>
                </td>
                <td class="border-left-0" width="100">
                  <center><p class="font-10 m-0 {{$i+1 >= sizeof($subjects) ? 'text-white' : ''}}">{{  ($i+1 >= sizeof($subjects) ? "xxx" : $subjects[$i+1]->subjectCode) }}</p></center>
                </td>
                <td class="border-left-0" width="50">
                  <center><p class="font-10 m-0 {{$i+1 >= sizeof($subjects) ? 'text-white' : ''}}">{{  ($i+1 >= sizeof($subjects) ? "xxx" : $subjects[$i+1]->subjectCredits) }}</p></center>
                </td>
            </tr>
          @endfor
          <tr>
            <td class="border-left-0" colspan="4">
              <p class="font-10 mt-1 ml-3 mb-0 mr-0"> OBSERVACIONES </p>
            </td>
            <td class="border-left-0">
              <p class="font-10 mt-1 ml-3 mb-0 mr-0"> TOTAL CRÉDITOS </p>
            </td>
            <td class="border-left-0">
              <p class="font-10 mt-1 ml-3 mb-0 mr-0"> {{ $totalCreditos }} </p>
            </td>
          </tr>
          <tr>
            <td class="border-left-0" colspan="6">
              <p class="font-10 mt-1 ml-3 mb-0 mr-0 {{$currentVoucher->observations ? '' : 'text-white'}}"> {{$currentVoucher->observations ? $currentVoucher->observations : 'x'}} </p>
            </td>
          </tr>
      </table>

      <br/>

      <table>
        <tr>
          <td class="border-left-0">
            <center><p class="font-10 m-0">SUBCOMISIÓN DE EQUIVALENCIA</p></center>
          </td>
          <td class="border-left-0">
            <center><p class="font-10 m-0">COMISIÓN DE EQUIVALENCIA</p></center>
          </td>
          <td class="border-left-0">
            <center><p class="font-10 m-0">CONSEJO DE FACULTAD</p></center>
          </td>
          <td class="border-left-0">
            <center><p class="font-10 m-0">CONSEJO UNIVERSITARIO</p></center>
          </td>
        </tr>


        <tr>
          <td class="border-left-0 border-top-0">
            <table>
              <tr>
                <td class="border-top-0 border-right-0 border-left-0">
                  <p class="font-10 m-0 ml-5" style="text-align: left">NOMBRE Y APELLIDO</p>
                </td>
                <td class="border-top-0 border-right-0 border-left-0">
                  <p class="font-10 m-0">FIRMA</p>
                </td>
              </tr>

              <tr class="border border-danger">
                <td class="border-right-0 border-left-0">
                  @if ($footer != [])
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer[0]->subComiOne }}</p>
                  @else
                    <p class="mt-1 ml-3 mb-1 mr-0 text-white" style="text-align: left"> x </p>
                  @endif

                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left"></p>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  @if ($footer != [])
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer[0]->subComiTwo }}</p>
                  @else
                    <p class="mt-1 ml-3 mb-1 mr-0 text-white" style="text-align: left"> x </p>
                  @endif
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  @if ($footer != [])
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer[0]->subComiThree }}</p>
                  @else
                    <p class="mt-1 ml-3 mb-1 mr-0 text-white" style="text-align: left"> x </p>
                  @endif
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>


              <tr>
                <td colspan="2" class="border-left-0 border-right-0 border-bottom-0">
                  @if ($currentVoucher->date_subcomi_eq)
                    <p class="mt-1 ml-3 mb-1 mr-0"> Fecha: {{ substr($currentVoucher->date_subcomi_eq, 8, 2) }}/{{ substr($currentVoucher->date_subcomi_eq, 5, 2) }}/{{ substr($currentVoucher->date_subcomi_eq, 0, 4) }}</p>
                  @else
                    <p class="mt-1 ml-3 mb-1 mr-0"> Fecha:
                      <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                      /
                      <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                      /
                    </p>
                  @endif

                </td>
              </tr>

              <tr>
                <td colspan="2" class="border-0 mt-3">
                  <p class="mt-1 ml-3 mb-1 mr-0">Sello: </p>
                </td>
              </tr>

            </table>
          </td>

          <td class="border-left-0 border-top-0">
            <table>
              <tr>
                <td class="border-top-0 border-right-0 border-left-0">
                  <p class="font-10 m-0 ml-5" style="text-align: left">NOMBRE Y APELLIDO</p>
                </td>
                <td class="border-top-0 border-right-0 border-left-0">
                  <p class="font-10 m-0">FIRMA</p>
                </td>
              </tr>

              <tr class="border border-danger">
                <td class="border-right-0 border-left-0">
                  @if ($footer != [])
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer[0]->comiOne }}</p>
                  @else
                    <p class="mt-1 ml-3 mb-1 mr-0 text-white" style="text-align: left"> x </p>
                  @endif
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left"></p>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  @if ($footer != [])
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer[0]->comiTwo }}</p>
                  @else
                    <p class="mt-1 ml-3 mb-1 mr-0 text-white" style="text-align: left"> x </p>
                  @endif
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  @if ($footer != [])
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer[0]->comiThree }}</p>
                  @else
                    <p class="mt-1 ml-3 mb-1 mr-0 text-white" style="text-align: left"> x </p>
                  @endif
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>


              <tr>
                <td colspan="2" class="border-left-0 border-right-0 border-bottom-0">
                @if($currentVoucher->date_comi_eq)
                  <p class="mt-1 ml-3 mb-1 mr-0">Fecha: {{ substr($currentVoucher->date_comi_eq, 8, 2) }}/{{ substr($currentVoucher->date_comi_eq, 5, 2) }}/{{ substr($currentVoucher->date_comi_eq, 0, 4) }}</p>
                @else
                  <p class="mt-1 ml-3 mb-1 mr-0"> Fecha:
                    <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                    /
                    <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                    /
                  </p>
                @endif
                </td>
              </tr>

              <tr>
                <td colspan="2" class="border-0 mt-3">
                  <p class="mt-1 ml-3 mb-1 mr-0">Sello: </p>
                </td>
              </tr>

            </table>
          </td>

          <td class="border-left-0">
            <table>
              <tr>
                <td colspan="2" class="border-0 mb-4">
                  <center>
                    @if ($currentVoucher->date_con_fac)
                      <p class="mt-1 ml-3 mb-1 mr-0"> Fecha: {{ substr($currentVoucher->date_con_fac, 8, 2) }}/{{ substr($currentVoucher->date_con_fac, 5, 2) }}/{{ substr($currentVoucher->date_con_fac, 0, 4) }}</p>
                    @else
                      <p class="mt-1 ml-3 mb-1 mr-0"> Fecha:
                        <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                        /
                        <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                        /
                      </p>
                    @endif
                  </center>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="border-0">
                  <center>
                    @if ($footer != [])
                      <span class=""><u>{{ $footer[0]->decano }}</u></span>
                    @else
                      <span class=""><u> </u></span>
                    @endif

                    <p class="mt-1 mb-1">DECANO</p>
                  </center>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="border-0 mt-5">
                  <p class="mt-1 ml-3 mb-1 mr-0">Sello: </p>
                </td>
              </tr>
            </table>
          </td>
          <td class="border-left-0">
            <table>
              <tr>
                <td colspan="2" class="border-0 mb-4">
                  <center>
                    @if ($currentVoucher->date_con_univ)
                      <p class="mt-1 ml-3 mb-1 mr-0"> Fecha: {{ substr($currentVoucher->date_con_univ, 8, 2) }}/{{ substr($currentVoucher->date_con_univ, 5, 2) }}/{{ substr($currentVoucher->date_con_univ, 0, 4) }}</p>
                    @else
                      <p class="mt-1 ml-3 mb-1 mr-0"> Fecha:
                        <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                        /
                        <span class="mt-1 mb-1 mr-0 text-white"> x </span>
                        /
                      </p>
                    @endif
                  </center>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="border-0">
                  <center>
                    <span class=""><u></u></span>
                    <p class="mt-1 mb-1">SECRETARIO</p>
                  </center>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="border-0 mt-5">
                  <p class="mt-1 ml-3 mb-1 mr-0">Sello: </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

    </div>
    <center>
      <span class="m-0" style="color:red; font-size:12px;">{{ $duplicates }}</span>
    </center>
  </div>
