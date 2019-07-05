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
            url: "{{ url($crud->route) }}/generarPdfComprobante/"+id,
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
            success: function(result) {
                // ejecuto
                var blob = new Blob([result]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Comprobante"+id+".pdf";
                // link.target = '_blank';
                link.click();
            },
            error: function(result) {
                // no ejecuto
            }
        });
      }
	}
</script>
