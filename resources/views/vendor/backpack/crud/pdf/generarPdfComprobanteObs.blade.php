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
          <h6 class="idSolicitud">No. <span style="color:red; font-size:18px;">{{$voucherId}}</span></h6>
          <center>
            <h6> COMPROBANTE DE ASIGNATURAS EQUIVALENTES </h6>
          </center>
      </div>

      <table>
        <!-- Inicio de las observaciones -->
        <tr>
          <td colspan="4" class="border-left-0">
            <p class="font-10 m-0">OBSERVACIONES</p>
          </td>
        </tr>

        <tr>
          <td colspan="4" class="border-left-0">
            <p class="mt-0 ml-3 mb-0 mr-0">
                {{ $observations }}
            </p>
          </td>
        </tr>
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
                  @if ($footer != [])
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer->subComiOne }}</p>
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
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer->subComiTwo }}</p>
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
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer->subComiThree }}</p>
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
                  @if ($dateSubComi)
                    <p class="mt-1 ml-3 mb-1 mr-0"> Fecha: {{ substr($dateSubComi, 8, 2) }}/{{ substr($dateSubComi, 5, 2) }}/{{ substr($dateSubComi, 0, 4) }}</p>
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
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer->comiOne }}</p>
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
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer->comiTwo }}</p>
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
                    <p class="mt-1 ml-3 mb-1 mr-0" style="text-align: left">{{ $footer->comiThree }}</p>
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
                @if($dateComi)
                  <p class="mt-1 ml-3 mb-1 mr-0">Fecha: {{ substr($dateComi, 8, 2) }}/{{ substr($dateComi, 5, 2) }}/{{ substr($dateComi, 0, 4) }}</p>
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
                    @if ($dateConFac)
                      <p class="mt-1 ml-3 mb-1 mr-0"> Fecha: {{ substr($dateConFac, 8, 2) }}/{{ substr($dateConFac, 5, 2) }}/{{ substr($dateConFac, 0, 4) }}</p>
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
                      <span class=""><u>{{ $footer->decano }}</u></span>
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
                    @if ($dateUniv)
                      <p class="mt-1 ml-3 mb-1 mr-0"> Fecha: {{ substr($dateUniv, 8, 2) }}/{{ substr($dateUniv, 5, 2) }}/{{ substr($dateUniv, 0, 4) }}</p>
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
