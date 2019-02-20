$("document").ready(function() {
  // Seteo la configuracion del validador
  $.validator.setDefaults({
    normalizer: function(value) {
      return $.trim(value);
    },
    submitHandler: function(form) {
      form.submit();
    },
    onfocusout: function(element) {
      $(element).valid();
    },
    errorElement: "span",
    errorPlacement: function(error, element) {
      error.addClass("help-block");
      error.insertAfter(element);
    },
    highlight: function(element, errorClass, validClass) {
      $(element)
        .closest(".form-control")
        .removeClass("is-valid")
        .addClass("is-invalid");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element)
        .closest(".form-control")
        .removeClass("is-invalid")
        .addClass("is-valid");
    }
  });

  // Permitir caracteres alfabeticos y espacios
  $.validator.addMethod("alfabeticos", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
  });

  // Formulario de inicio de sesion
  $("#formIniciarSesion").validate({
    rules: {
      cedula: {
        required: true,
        number: true,
        minlength: 7
      },
      contrasena: {
        required: true,
        minlength: 6,
        maxlength: 15
      }
    },
    messages: {
      cedula: {
        required: "Por favor, ingrese su cedula",
        number: "Ingrese una cedula valida",
        minlength: "Su cedula debe contener al menos 7 digitos"
      },
      contrasena: {
        required: "Por favor, ingrese su contrasena",
        minlength: "Su contrasena debe tener al menos 6 caracteres",
        maxlength: "Su contrasena debe tener a lo sumo 15 caracteres"
      }
    }
  });

  //formualrio de registro
  $("#formRegistrarme").validate({
    rules: {
      cedula: {
        required: true,
        number: true,
        minlength: 7
      },
      nombres: {
        required: true,
        alfabeticos: true,
        minlength: 3,
        maxlength: 50
      },
      apellidos: {
        required: true,
        alfabeticos: true,
        minlength: 3,
        maxlength: 50
      },
      lugarDeNacimiento: {
        required: true,
        alfabeticos: true,
        minlength: 3,
        maxlength: 50
      },
      nacionalidad: {
        required: true
      },
      fechaDeNacimiento: {
        required: true
      },
      sexo: {
        required: true
      },
      contrasena: {
        required: true,
        minlength: 6,
        maxlength: 15
      },
      reContrasena: {
        required: true,
        equalTo: "#contrasena"
      },
      correo: {
        required: true,
        email: true
      },
      telefono: {
        required: true,
        number: true,
        maxlength: 12
      }
    },
    messages: {
      cedula: {
        required: "Por favor, ingrese su cedula",
        number: "Ingrese una cedula valida",
        minlength: "Su cedula debe contener al menos 7 digitos"
      },
      nombres: {
        required: "Por favor, ingrese su nombre",
        alfabeticos: "Ingrese un nombre valido",
        minlength: "Su nombre debe contener minimo 3 caracteres",
        maxlength: "Su nombre debe contener a lo sumo 50 caracteres"
      },
      apellidos: {
        required: "Por favor, ingrese su apellido",
        alfabeticos: "Ingrese un apellido valido",
        minlength: "Su apellido debe contener minimo 3 caracteres",
        maxlength: "Su apellido debe contener a lo sumo 50 caracteres"
      },
      lugarDeNacimiento: {
        required: "Por favor, ingrese su lugar de nacimiento",
        alfabeticos: "Ingrese un lugar de nacimiento valido",
        minlength: "Su lugar de nacimiento debe contener minimo 3 caracteres",
        maxlength:
          "Su lugar de nacimiento debe contener a lo sumo 50 caracteres"
      },
      nacionalidad: {
        required: "Por favor, seleccione su nacionalidad"
      },
      fechaDeNacimiento: {
        required: "Por favor, ingrese su fecha de nacimiento"
      },
      sexo: {
        required: "Por favor, seleccione su sexo"
      },
      contrasena: {
        required: "Por favor, ingrese su contrasena",
        minlength: "Su contrasena debe tener al menos 6 caracteres",
        maxlength: "Su contrasena debe tener a lo sumo 15 caracteres"
      },
      reContrasena: {
        required: "Por favor, confirme su contrasena",
        equalTo: "Las contrasenas no coinciden"
      },
      correo: {
        required: "Por favor, su correo electronico",
        email: "Ingrese un correo electronico valido"
      },
      telefono: {
        required: "Por favor, ingrese su numero de telefono",
        number: "Ingrese un numero de telefono valido",
        maxlength: "Su telefono debe tener a lo sumo 12 digitos"
      }
    }
  });

  //formulario para datos personales
  $("#formDatosPersonales").validate({
    rules: {
      nombres: {
        required: true,
        alfabeticos: true,
        minlength: 3,
        maxlength: 50
      },
      apellidos: {
        required: true,
        alfabeticos: true,
        minlength: 3,
        maxlength: 50
      },
      lugarDeNacimiento: {
        required: true,
        alfabeticos: true,
        minlength: 3,
        maxlength: 50
      },
      nacionalidad: {
        required: true
      },
      fechaDeNacimiento: {
        required: true
      },
      sexo: {
        required: true
      },
      correo: {
        required: true,
        email: true
      },
      telefono: {
        required: true,
        number: true,
        maxlength: 12
      }
    },
    messages: {
      nombres: {
        required: "Por favor, ingrese su nombre",
        alfabeticos: "Ingrese un nombre valido",
        minlength: "Su nombre debe contener minimo 3 caracteres",
        maxlength: "Su nombre debe contener a lo sumo 50 caracteres"
      },
      apellidos: {
        required: "Por favor, ingrese su apellido",
        alfabeticos: "Ingrese un apellido valido",
        minlength: "Su apellido debe contener minimo 3 caracteres",
        maxlength: "Su apellido debe contener a lo sumo 50 caracteres"
      },
      lugarDeNacimiento: {
        required: "Por favor, ingrese su lugar de nacimiento",
        alfabeticos: "Ingrese un lugar de nacimiento valido",
        minlength: "Su lugar de nacimiento debe contener minimo 3 caracteres",
        maxlength:
          "Su lugar de nacimiento debe contener a lo sumo 50 caracteres"
      },
      nacionalidad: {
        required: "Por favor, seleccione su nacionalidad"
      },
      fechaDeNacimiento: {
        required: "Por favor, ingrese su fecha de nacimiento"
      },
      sexo: {
        required: "Por favor, seleccione su sexo"
      },
      correo: {
        required: "Por favor, su correo electronico",
        email: "Ingrese un correo electronico valido"
      },
      telefono: {
        required: "Por favor, ingrese su numero de telefono",
        number: "Ingrese un numero de telefono valido",
        maxlength: "Su telefono debe tener a lo sumo 12 digitos"
      }
    }
  });

  //formualrio de registro
  $("#formCambiarContrasena").validate({
    rules: {
      antiguaContrasena: {
        required: true,
        minlength: 6,
        maxlength: 15
      },
      nuevaContrasena: {
        required: true,
        minlength: 6,
        maxlength: 15
      },
      confirNuevaContrasena: {
        required: true,
        equalTo: "#nuevaContrasena"
      }
    },
    messages: {
      antiguaContrasena: {
        required: "Por favor, ingrese su antigua contrasena",
        minlength: "Su antigua contrasena debe tener al menos 6 caracteres",
        maxlength: "Su antigua contrasena debe tener a lo sumo 15 caracteres"
      },
      nuevaContrasena: {
        required: "Por favor, ingrese su nueva contrasena",
        minlength: "Su nueva contrasena debe tener al menos 6 caracteres",
        maxlength: "Su nueva contrasena debe tener a lo sumo 15 caracteres"
      },
      confirNuevaContrasena: {
        required: "Por favor, confirme su nueva contrasena",
        equalTo: "Las nuevas contrasenas no coinciden"
      }
    }
  });
});
