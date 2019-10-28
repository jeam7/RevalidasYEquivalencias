<a href="javascript:void(0)"
    onclick="createVoucherFromRequest(this)"
    id= "{{$entry->getKey()}}"
    class="btn btn-xs btn-default"
    data-style="zoom-in"
    data-route="{{ url($crud->route.'/'.$entry->getKey()) }}">
  <span class="ladda-label">
    <i class="fa fa-plus"></i> Añadir Comprobante
  </span>
</a>

<script>
if (typeof createVoucherFromRequest != 'function') {
function createVoucherFromRequest(button) {
    var button = $(button);
    let id = button.attr('id');
    let route = button.attr('data-route');
    let row = $("#crudTable a[data-route='"+route+"']").closest('tr');

    $.ajax({
        url: "{{ url('/admin/voucher/createVoucherFromRequest') }}/"+id,
        type: 'post',
        success: function(result) {
            console.log(result);
            console.log("request id que estoy enviando: " + id);
            if (result == 300) {
              new PNotify({
                  title: "",
                  text: "La Solicitud ya posee un comprobante registrado.",
                  type: "warning"
              });
            }else {
              if (row.hasClass("shown")) {
                row.next().remove();
              }

              row.remove();

              new PNotify({
                  title: "",
                  text: "El elemento ha sido añadido de manera correcta.",
                  type: "success"
              });
            }
        },
        error: function(result) {
            new PNotify({
                title: "",
                text: "El elemento no ha sido añadido, por favor intente mas tarde.",
                type: "warning"
            });
        }
    });
  }
}
</script>
