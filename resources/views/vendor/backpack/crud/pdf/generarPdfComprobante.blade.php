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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <div class="page-break">


    <div class="border border-dark">
      <div id="watermark">
          <img src="images/logoUCV.png" height="100%" width="100%" />
      </div>
      <div class="">
            <p class="font-weight-bold m-1 mt-2 font-10">UNIVERSIDAD CENTRAL DE VENEZUELA</p>
            <p class="font-weight-bold m-1 font-10">CONSEJO UNIVERSITARIO</p>
            <p class="font-weight-bold m-1 font-10">SECRETARIA</p>
          <h6 class="idSolicitud">No. <span style="color:red; font-size:18px;">{{$voucherId}}</span></h6>
          <center>
            <h6> COMPROBANTE DE ASIGNATURAS EQUIVALENTES </h6>
          </center>
      </div>

      <table>
        <tr>
          <td class="border-left-0" width="160">
            <center><p class="font-10 m-0">FACULTAD DONDE DESEA CURSAR</p></center>
          </td>
          <td class="border-left-0" width="160">
            <center><p class="font-10 m-0">ESCUELA O ESPECIALIDAD</p></center>
          </td>
          <td class="border-left-0" width="160">
            <center><p class="font-10 m-0">UNIVERSIDAD O INSTITUTO DONDE DESEA CURSAR</p></center>
          </td>
          <td class="border-left-0" width="60">
            <center><p class="font-10 m-0">PAG.</p></center>
          </td>
        </tr>

        <tr>
          <td class="border-left-0"  width="160">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{ $dataVoucher->request->career_destination->school->faculty->name }} </p>
          </td>
          <td class="border-left-0" width="160">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{$dataVoucher->request->career_destination->school->name}} </p>
          </td>
          <td class="border-left-0" width="160">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{$dataVoucher->request->career_destination->school->faculty->college->name}} </p>
          </td>
          <td class="border-left-0" width="60">
            <p class="mt-0 ml-3 mb-0 mr-0"> 1 </p>
          </td>
        </tr>

        <tr>
          <td class="border-left-0" width="160">
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
          <td class="border-left-0"  width="160">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{ $dataUser->last_name }} </p>
          </td>
          <td class="border-left-0" width="160">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{ $dataUser->first_name }} </p>
          </td>
          <td class="border-left-0" width="160">
            <p class="mt-0 ml-3 mb-0 mr-0">{{ strtoupper($dataUser->nacionality) }} - {{ $dataUser->ci }}</p>
          </td>
          <td class="border-left-0" width="60">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{ $requestId }} </p>
          </td>
        </tr>

        <tr>
          <td class="border-left-0">
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
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{$dataVoucher->request->career_origin->school->faculty->name}} </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{ $dataVoucher->request->career_origin->school->name }} </p>
          </td>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> {{ $dataVoucher->request->career_origin->school->faculty->college->name }} </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0">
            <center><p class="font-10 m-0">ASIGNATURAS EQUIVALENTES</p></center>
          </td>
          <td class="border-left-0">
            <center><p class="font-10 m-0">CODIGO DE MATERIAS</p></center>
          </td>
          <td class="border-left-0">
            <center><p class="font-10 m-0">UNIDADES DE CREDITO</p></center>
          </td>
        </tr>
        <!-- Inicio de la renderizacion de materias -->
        <tr>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> El for </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> para renderizar </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> las materias </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> El for </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> para renderizar </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> las materias </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> El for </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> para renderizar </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> las materias </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> El for </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> para renderizar </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> las materias </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> El for </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> para renderizar </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> las materias </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> El for </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> para renderizar </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> las materias </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> El for </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> para renderizar </p>
          </td>
          <td class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0"> las materias </p>
          </td>
        </tr>

        <!-- Fin renderiza -->
        <tr>
          <td colspan="3" class="border-left-0">
            <p class="mt-1 ml-3 mb-1 mr-0"> Total creditos </p>
          </td>
          <td class="border-left-0">
            <p class="mt-1 ml-3 mb-1 mr-0"> 200 </p>
          </td>
        </tr>

        <!-- Inicio de las observaciones (Creo que se van) -->
        <!-- <tr>
          <td colspan="4" class="border-left-0">
            <p class="font-10 m-0">OBSERVACIONES</p>
          </td>
        </tr>

        <tr>
          <td colspan="4" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut porttitor elit vel blandit varius. Aenean massa felis, tempus non enim at, tincidunt posuere lorem. Aliquam facilisis semper rhoncus. Sed eget interdum est, sed efficitur sem. Praesent eu magna leo. Quisque placerat tristique semper. Vivamus id turpis augue. Aenean aliquet sem ex, sed suscipit ipsum condimentum in. Vestibulum fringilla eget diam id vehicula. Phasellus lacinia eget lorem ut consequat. Curabitur lectus purus, hendrerit quis consectetur sit amet, consectetur vitae nunc. Donec condimentum laoreet leo in maximus.
            </p>
          </td>
        </tr> -->
      <!-- Fin de las observaciones -->
      </table>
      <br/>
      <table>
        <tr>
          <td class="border-left-0">
            <center><p class="font-10 m-0">SUBCOMISION DE EQUIVALENCIA</p></center>
          </td>
          <td class="border-left-0">
            <center><p class="font-10 m-0">COMISION DE EQUIVALENCIA</p></center>
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
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">NOMBRE Y APELLIDO 1</p>
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left"></p>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">NOMBRE Y APELLIDO 2</p>
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">NOMBRE Y APELLIDO 3</p>
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>


              <tr>
                <td colspan="2" class="border-left-0 border-right-0 border-bottom-0">
                  <p class="mt-1 ml-3 mb-1 mr-0">Fecha: 07/10/1992</p>
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
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">NOMBRE Y APELLIDO 1</p>
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left"></p>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">NOMBRE Y APELLIDO 2</p>
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>

              <tr>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">NOMBRE Y APELLIDO 3</p>
                </td>
                <td class="border-right-0 border-left-0">
                  <p class="mt-1 ml-3 mb-1 mr-0"></p></center>
                </td>
              </tr>


              <tr>
                <td colspan="2" class="border-left-0 border-right-0 border-bottom-0">
                  <p class="mt-1 ml-3 mb-1 mr-0">Fecha: 07/10/1992</p>
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
                    <p class="mt-1 ml-3 mb-1 mr-0">Fecha: 07/10/1992</p>
                  </center>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="border-0">
                  <center>
                    <span class=""><u>Nombre decano</u></span>
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
                    <p class="mt-1 ml-3 mb-1 mr-0">Fecha: 07/10/1992</p>
                  </center>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="border-0">
                  <center>
                    <span class=""><u>Nombre secretario</u></span>
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
