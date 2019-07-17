<a href="javascript:void(0)" onclick="verPdf(this)" class="btn btn-xs btn-default" id= "{{$entry->getKey()}}">
  <i class="fa fa-file-pdf-o"></i>
  Descargar
</a>

<script>
	if (typeof verPdf != 'function') {
	  function verPdf(button) {
        var button = $(button);
        var id = button.attr('id');

        $.ajax({
            url: "{{ url($crud->route) }}/generarPdfSolicitud/"+id,
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
            success: function(result) {
                // ejecuto
                var blob = new Blob([result]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Solicitud"+id+".pdf";
                link.click();
            },
            error: function(result) {
                // no ejecuto
            },
            beforeSend: function () {
              var loader = '<div id="loading" class="bg-black" style="opacity: 0.5; height:100%; width:100%; position:absolute; top:0; margin-left: 0%;">';
              loader += '<img src="{{asset('images/loader.gif')}}" alt="loading" style="width: 32px; height: 32px; position: absolute; top: 35%; left: 45%;" />';
              loader += '</div>';
              $('.content-wrapper').append(loader);
            },
            complete: function(){
              $("#loading").remove();
            }
        });
      }
	}
</script>
