$("document").ready(function() {
  //Desplegar modal con mensajes
  if ($("#mensaje").text()) {
    $("#modalMensaje").modal("show");
  }

  // $("#botonEditar").click(function(event) {
  //   event.preventDefault();
  //   let allInputs = $(":input");
  //   $(allInputs).prop("disabled", false);
  //   $("#botonEditar").prop("disabled", true);
  // });
});
