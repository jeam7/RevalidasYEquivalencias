<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
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

    .borderPrincipal{
      height: 970px;
    }

    .idSolicitud{
      position: absolute;
      top: 45;
      left: 480;
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

  </style>
</head>
<body>
    <div class="border border-dark borderPrincipal">
      <div class="border-bottom border-dark">
          <center>
            <h5 class="font-weight-bold m-1">UNIVERSIDAD CENTRAL DE VENEZUELA</h5>
            <h6>CONSEJO UNIVERSITARIO</h6>
            <h6>SECRETARIA</h6>
            <h6 class="font-weight-bold">SOLICITUD DE EQUIVALENCIA</h6>
          </center>
          <h6 class="idSolicitud">No. <span style="color:red; font-size:20px;">{{ $currentRequest['id'] }}</span></h6>
      </div>

      <table>
        <tr>
          <td colspan="2" class="border-left-0" width="40%">
            <p class="font-10 m-0 ml-2">APELLIDO(S)</p>
            <p class="m-0 ml-3">{{ $currentUser['last_name']}}</p>
          </td>
          <td colspan="3" width="40%">
            <p class="font-10 m-0 ml-2">NOMBRE(S)</p>
            <p class="m-0 ml-3">{{ $currentUser['first_name']}}</p>
          </td>
          <td class="border-right-0" width="20%">
            <p class="font-10 m-0 ml-2">CEDULA DE IDENTIDAD</p>
            <p class="m-0 ml-3">{{ $currentUser['ci']}}</p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-left-0" width="40%">
            <p class="font-10 m-0 ml-2">LUGAR DE NACIMIENTO</p>
            <p class="m-0 ml-3">{{ $currentUser['place_birth'] }}</p>
          </td>
          <td colspan="2" width="20%">
            <p class="font-10 m-0 ml-2">NACIONALIDAD</p>
            <p class="m-0 ml-3">
              @if ($currentUser['nacionality'] == "v")
                Venezolano
              @else
                Extranjero
              @endif
            </p>
          </td>
          <td width="20%">
            <p class="font-10 m-0 ml-2">FECHA DE NACIMIENTO</p>
            <p class="m-0 ml-3">{{ $currentUser['birthdate'] }}</p>
          </td>
          <td class="border-right-0 border-bottom border-dark" width="10%">
            <p class="font-10 m-0 ml-2">SEXO</p>
            <p class="m-0 ml-3">
              @if ($currentUser['gender'] == "m")
                Masculino
              @else
                Femenino
              @endif
            </p>
          </td>
        </tr>

         <tr>
          <td colspan="5" class="border-left-0" width="70%">
            <p class="font-10 m-0 ml-2">DIRECCION</p>
            <p class="m-0 ml-3">{{ $currentUser['address'] }}</p>
          </td>

          <td class="border-right-0 border-bottom border-dark" width="30%">
            <p class="font-10 m-0 ml-2">TELEFONO</p>
            <p class="m-0 ml-3">{{ $currentUser['phone'] }}</p>
          </td>
        </tr>

        <tr>
          <td colspan="6" class="border-left-0 border-right-0" width="100%">
            <p class="font-10 m-0 ml-2">UNIVERSIDAD O INSTITUTO DE PROCEDENCIA</p>
            <p class="m-0 ml-3">{{ $currentUserOriginU['name'] }}</p>
          </td>
        </tr>

        <tr>
          <td colspan="6" class="border-left-0 border-right-0" width="100%">
            <p class="font-10 m-0 ml-2">DIRECCION DE LA UNIVERSIDAD O INSTITUTO, EN CASO DE SER EXTRANJERA</p>
            <p class="m-0 ml-3">
              @if ($currentRequest['origin'] == "1")
                N/A
              @else
                {{ $currentUserOriginU['address'] }}
              @endif
            </p>
          </td>
        </tr>

        <tr>
          <td colspan ="2" class="border-left-0" width="33.3%">
            <p class="font-10 m-0 ml-2">FACULTAD DE LOS ESTUDIOS CURSADOS</p>
            <p class="m-0 ml-3">{{ $currentUserOriginF['name'] }}</p>
          </td>
          <td colspan ="2" width="33.4%">
            <p class="font-10 m-0 ml-2">ESCUELA DE LOS ESTUDIOS CURSADOS</p>
            <p class="m-0 ml-3">{{ $currentUserOriginS['name'] }}</p>
          </td>
          <td colspan ="2" class="border-right-0" width="33.3%">
            <p class="font-10 m-0 ml-2">CARRERA DE LOS ESTUDIOS CURSADOS</p>
            <p class="m-0 ml-3">{{ $currentUserOriginC['name'] }}</p>
          </td>
        </tr>

        <tr>
          <td colspan ="2" class="border-left-0" width="33.3%">
            <p class="font-10 m-0 ml-2">FACULTAD DONDE DESEA CURSAR</p>
            <p class="m-0 ml-3">{{ $currentUserDestinationF['name'] }}</p>
          </td>
          <td colspan ="2" width="33.4%">
            <p class="font-10 m-0 ml-2">ESCUELA DONDE DESEA CURSAR</p>
            <p class="m-0 ml-3">{{ $currentUserDestinationS['name'] }}</p>
          </td>
          <td colspan ="2" class="border-right-0" width="33.3%">
            <p class="font-10 m-0 ml-2">CARRERA DONDE DESEA CURSAR</p>
            <p class="m-0 ml-3">{{ $currentUserDestinationC['name'] }}</p>
          </td>
        </tr>

        <tr>
          <td colspan="6" class="border-0" width="100%">
            <center><h6 class="font-weight-bold mt-1">DATOS ENTREGADOS</h6></center>
            <p class="font-12 m-0 ml-3 mb-1">PARA LOS QUE PROCEDEN DE ESTA UNIVERISDAD O DE OTRA UNIVERSIDAD NACIONAL:</p>
          </td>
        </tr>
        <tr>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              OTROS:
              @if ($currentRequest['others'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              PENSUM:
              @if ($currentRequest['pensum'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              CERTIFICACION DE NOTAS (ORIGINAL):
              @if ($currentRequest['notes'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">PROGRAMAS DE ESTUDIOS (AUTENTICADOS):
              @if ($currentRequest['study_programs'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
        </tr>

        <tr>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">SI ES EGRESADO UNIVERSITARIO, COPIA DEL TITULO:
              @if ($currentRequest['title'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              FOTOCOPIA DE LA CEDULA DE IDENTIDAD:
              @if ($currentRequest['copy_ci'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="6" class="border-right-0 border-left-0 border-bottom-0 border-top border-dark" width="100%">
            <p class="font-12 m-0 ml-3 mb-1">PARA LOS QUE PROCEDEN DE UNA UNIVERSIDAD EXTRANJERA: </p>
          </td>
        </tr>
        <tr>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              CEDULA DE IDENTIDAD O PASAPORTE(FOTOCOPIA):
              @if ($currentRequest['ci_passport_copy'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              CERTIFICACION DE NOTAS, LEGALIZADAS POR LAS AUTORIDADES COMPETENTES (ORIGINAL Y FOTOCOPIA):
              @if ($currentRequest['notes_legalized'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">PROGRAMAS DE ESTUDIOS (ORIGINALES, LEGALIZADOS):
              @if ($currentRequest['study_program_legalized'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
             </p>
          </td>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              CERTIFICACION DE LA CATEGORIA UNIVERSITARIA DEL INSTITUTO DE PROCEDENCIA (OFICIALMENTE RECONOCIDA POR LAS AUTORIDADES DEL PAIS DE ORIGEN):
              @if ($currentRequest['cerification_category_college'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              CERTIFICACION EN DONDE CONSTE QUE NO LE HA SIDO CONFERIDO EL TITULO CORRESPONDIENTE (EN CASO DE HABER APROBADO TODOS LOS AÑOS DE ESTUDIO SIN OBTENER EL TITULO):
              @if ($currentRequest['certification_title_no_confered'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
          <td colspan="3" class="border-0" width="50%">
            <p class="ml-3 font-12 mb-1">
              TRADUCCION AL CASTELLANO POR INTERPRETE PUBLICO AUTORIZADO, EN CASO DE ESTAR LA DOCUMENTACION EN IDIOMA EXTRANJERO (ORIGINAL Y FOTOCOPIA):
              @if ($currentRequest['translation'])
                <span style="color:red">X</span>
              @else
                N/A
              @endif
            </p>
          </td>
        </tr>

        <tr>
          <td colspan="2" class="border-right-0 border-left-0 border-bottom border-top border-dark m-3" width="100%">
            <p class="font-12 m-0 ml-3 mb-1">FIRMA DEL SOLICITANTE: </p>
          </td>
          <td colspan="2" class="border-right-0 border-left-0 border-bottom border-top border-dark m-3" width="100%">
            <p class="font-12 m-0 ml-3 mb-1">CEDULA DE IDENTIDAD: {{ $currentUser['ci'] }}</p>
          </td>
          <td colspan="2" class="border-right-0 border-left-0 border-bottom border-top border-dark m-3" width="100%">
            <p class="font-12 m-0 ml-3 mb-1">FECHA: {{ substr($currentRequest['created_at'],0,10) }}</p>
          </td>
        </tr>

        <tr>
          <td colspan="6" class="border-right-0 border-left-0 border-bottom border-top border-dark" width="100%">
            <center><h6 class="font-weight-bold mt-1">SECRETARIA DEL CONSEJO UNIVERSITARIO</h6></center>
          </td>
        </tr>

        <tr>
          <td colspan="1" class="border-left-0" width="40%">
            <center><p class="font-12 m-1">RECIBIDO POR:</p></center>
          </td>
          <td colspan="1" width="40%">
            <center><p class="font-12 m-1">REVISADO POR:</p></center>
          </td>
          <td colspan="2" class="border-right-0" width="20%">
            <center><p class="font-12 m-1">ENVIADO A COMISION EQUICALENCIAS FACULTAD:</p></center>
          </td>
          <td colspan="2" class="border-right-0" width="20%">
            <center><p class="font-12 m-1">RECIBIDO DEL CONSEJO DE FACULTAD:</p></center>
          </td>
        </tr>

        <tr>
          <td colspan="1" class="border-left-0 mb-2  mt-3 border-bottom-0" width="40%">
            <p class="font-12 m-0 ml-2">FECHA: </p>
          </td>
          <td colspan="1" width="40%" class="border-bottom-0 mb-2 mt-3">
            <p class="font-12 m-0 ml-2">FECHA: </p>
          </td>
          <td colspan="2" class="border-right-0 border-bottom-0 mb-2 mt-3" width="20%">
            <p class="font-12 m-0 ml-2">FECHA: </p>
          </td>
          <td colspan="2" class="border-right-0 border-bottom-0 mb-2 mt-3" width="20%">
            <p class="font-12 m-0 ml-2">FECHA: </p>
          </td>
        </tr>

        <tr>
          <td colspan="1" class="border-left-0 border-top-0 border-bottom-0 mb-4 mt-2" width="40%">
            <p class="font-12 m-0 ml-2">FIRMA:</p>
          </td>
          <td colspan="1" width="40%" class=" border-top-0 border-bottom-0 mb-4 mt-2">
            <p class="font-12 m-0 ml-2">FIRMA:</p>
          </td>
          <td colspan="2" class="border-right-0 border-top-0 border-bottom-0 mb-4 mt-2" width="20%">
            <p class="font-12 m-0 ml-2">FIRMA:</p>
          </td>
          <td colspan="2" class="border-right-0 border-top-0 border-bottom-0 mb-4 mt-2" width="20%">
            <p class="font-12 m-0 ml-2">FIRMA:</p>
          </td>
        </tr>

      </table>

    </div>
</body>
</html>
