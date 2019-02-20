let express = require("express");
let router = express.Router();

let User = require("../Modules/users");

/* Home */
router.get("/", function(req, res, next) {
  let menu = [
    { option: "Home", active: 1, href: "./" },
    { option: "opcion1", active: 0, href: "./opcion1" },
    { option: "opcion2", active: 0, href: "./opcion2" },
    { option: "Registrarme", active: 0, href: "./registrarme" }
  ];
  res.render("./users/index", { menu: menu });
});

router.post("/", function(req, res, next) {
  let menu = [
    { option: "Home", active: 1, href: "./" },
    { option: "opcion1", active: 0, href: "./opcion1" },
    { option: "opcion2", active: 0, href: "./opcion2" },
    { option: "Registrarme", active: 0, href: "./registrarme" }
  ];

  User.iniciarSesion(req.body, function(err, data) {
    if (data.codigo == 0) {
      let usuario = {
        cedula: data.cedula,
        nombre: data.nombre,
        apellido: data.apellido,
        tipoUsuario: {
          solicitante: data.solicitante,
          personalIRE: data.personalIRE,
          personalAdm: data.personalAdm,
          superAdmin: data.superAdmin
        },
        lugarDeNacimiento: data.lugarDeNacimiento,
        nacionalidad: data.nacionalidad,
        fechaDeNacimiento: data.fechaDeNacimiento,
        sexo: data.sexo,
        correo: data.correo,
        telefono: data.telefono,
        direccion: data.direccion,
        contrasena: data.contrasena
      };
      req.session.usuario = usuario;
      res.render("./users/index", {
        menu: menu,
        data: data
      });
    } else {
      res.render("./users/index", {
        menu: menu,
        data: data
      });
    }
  });
});
/* fin Home */

// Inicio cerrar sesion
router.get("/cerrarSesion", function(req, res, next) {
  req.session.destroy();
  res.redirect("/");
});
// Fin cerrar sesion

/* opciones extra del home */
router.get("/opcion1", function(req, res, next) {
  let menu = [
    { option: "Home", active: 0, href: "./" },
    { option: "opcion1", active: 1, href: "./opcion1" },
    { option: "opcion2", active: 0, href: "./opcion2" },
    { option: "Registrarme", active: 0, href: "./registrarme" }
  ];
  res.render("./users/opcion1", { menu: menu });
});

router.get("/opcion2", function(req, res, next) {
  let menu = [
    { option: "Home", active: 0, href: "./" },
    { option: "opcion1", active: 0, href: "./opcion1" },
    { option: "opcion2", active: 1, href: "./opcion2" },
    { option: "Registrarme", active: 0, href: "./registrarme" }
  ];
  res.render("./users/opcion2", { menu: menu });
});
/*fin opciones extras del home*/

/*Reigstrarme*/
router.get("/registrarme", function(req, res, next) {
  let menu = [
    { option: "Home", active: 0, href: "./" },
    { option: "opcion1", active: 0, href: "./opcion1" },
    { option: "opcion2", active: 0, href: "./opcion2" },
    { option: "Registrarme", active: 1, href: "./registrarme" }
  ];
  res.render("./users/registrarme", { title: "registrarme", menu: menu });
});

router.post("/registrarme", function(req, res, next) {
  let menu = [
    { option: "Home", active: 0, href: "./" },
    { option: "opcion1", active: 0, href: "./opcion1" },
    { option: "opcion2", active: 0, href: "./opcion2" },
    { option: "Registrarme", active: 1, href: "./registrarme" }
  ];
  req.body.tipoUsuario = 3;
  req.body.idFacultad = null;

  User.registrarSolicitante(req.body, function(err, data) {
    res.render("./users/registrarme", {
      menu: menu,
      mensaje: data[0].mensaje
    });
  });
});
/*Fin registrarme*/

router.get("/principalPersonalIre", function(req, res, next) {
  let menu = [
    { option: "Solicitudes", active: 1, href: "" },
    { option: "Solicitantes", active: 0, href: "" },
    { option: "Universidad / Institutos", active: 0, href: "" },
    { option: "Asignaturas", active: 0, href: "" },
    { option: "Comprobantes", active: 0, href: "" }
  ];

  res.render("./users/principalPersonalIre", {
    menu: menu,
    usuario: req.session.usuario,
    tipoUsuario: "PersonalIRE"
  });
});

router.get("/principalPersonalAdmre", function(req, res, next) {
  let menu = [
    { option: "Solicitudes", active: 1, href: "" },
    { option: "Solicitantes", active: 0, href: "" },
    { option: "Universidad / Institutos", active: 0, href: "" },
    { option: "Asignaturas", active: 0, href: "" },
    { option: "Comprobantes", active: 0, href: "" },
    { option: "Usuarios", active: 0, href: "" },
    { option: "Memorandums", active: 0, href: "" },
    { option: "Configuraciones", active: 0, href: "" }
  ];
  res.render("./users/principalPersonalAdmre", {
    menu: menu,
    usuario: req.session.usuario,
    tipoUsuario: "personalADMRE"
  });
});

router.get("/principalSuperAdm", function(req, res, next) {
  let menu = [
    { option: "Solicitudes", active: 1, href: "" },
    { option: "Solicitantes", active: 0, href: "" },
    { option: "Universidad / Institutos", active: 0, href: "" },
    { option: "Asignaturas", active: 0, href: "" },
    { option: "Comprobantes", active: 0, href: "" },
    { option: "Usuarios", active: 0, href: "" },
    { option: "Memorandums", active: 0, href: "" },
    { option: "Configuraciones", active: 0, href: "" }
  ];
  res.render("./users/principalSuperAdm", {
    menu: menu
  });
});
// fin pantallas principales por tipo de usuario

//Inicio datos personales
router.get("/datosPersonales", function(req, res, next) {
  let menu = [
    {
      option: "Solicitudes",
      active: 0,
      href: "./solicitudes/principalSolicitante"
    },
    { option: "opcion1Solicitante", active: 0, href: "" },
    { option: "opcion2Solicitante", active: 0, href: "" },
    { option: "opcion3Solicitante", active: 0, href: "" }
  ];

  res.render("./users/datosPersonales", {
    menu: menu,
    usuario: req.session.usuario,
    tipoUsuario: "Solicitante"
  });
});

router.post("/datosPersonales", function(req, res, next) {
  let menu = [
    {
      option: "Solicitudes",
      active: 0,
      href: "./solicitudes/principalSolicitante"
    },
    { option: "opcion1Solicitante", active: 0, href: "" },
    { option: "opcion2Solicitante", active: 0, href: "" },
    { option: "opcion3Solicitante", active: 0, href: "" }
  ];
  req.body.cedula = req.session.usuario.cedula;

  User.editarDatosPersonales(req.body, function(err, data) {
    req.session.usuario.nombre = req.body.nombres;
    req.session.usuario.apellido = req.body.apellidos;
    req.session.usuario.lugarDeNacimiento = req.body.lugarDeNacimiento;
    req.session.usuario.nacionalidad = req.body.nacionalidad;
    req.session.usuario.fechaDeNacimiento = req.body.fechaDeNacimiento;
    req.session.usuario.sexo = req.body.sexo;
    req.session.usuario.correo = req.body.correo;
    req.session.usuario.telefono = req.body.telefono;
    req.session.usuario.direccion = req.body.direccion;
    res.render("./users/datosPersonales", {
      menu: menu,
      usuario: req.session.usuario,
      tipoUsuario: "Solicitante",
      mensaje: data[0].mensaje
    });
  });
});
//Fin datos personales

//Inicio cambiar contrasena
router.get("/cambiarContrasena", function(req, res, next) {
  let menu = [
    {
      option: "Solicitudes",
      active: 0,
      href: "./solicitudes/principalSolicitante"
    },
    { option: "opcion1Solicitante", active: 0, href: "" },
    { option: "opcion2Solicitante", active: 0, href: "" },
    { option: "opcion3Solicitante", active: 0, href: "" }
  ];

  res.render("./users/cambiarContrasena", {
    menu: menu,
    usuario: req.session.usuario,
    tipoUsuario: "Solicitante",
    mensaje: ""
  });
});

router.post("/cambiarContrasena", function(req, res, next) {
  let menu = [
    {
      option: "Solicitudes",
      active: 0,
      href: "./solicitudes/principalSolicitante"
    },
    { option: "opcion1Solicitante", active: 0, href: "" },
    { option: "opcion2Solicitante", active: 0, href: "" },
    { option: "opcion3Solicitante", active: 0, href: "" }
  ];
  req.body.contrasenaActual = req.session.usuario.contrasena;
  req.body.cedula = req.session.usuario.cedula;
  User.cambiarContrasena(req.body, function(err, data) {
    if (data.codigo == 0) {
      req.session.usuario.contrasena = data.nuevaContrasena;
    }
    res.render("./users/cambiarContrasena", {
      menu: menu,
      usuario: req.session.usuario,
      tipoUsuario: "Solicitante",
      mensaje: data.mensaje
    });
  });
});
//fin cambiar contrasena
module.exports = router;
