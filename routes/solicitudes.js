let express = require("express");
let router = express.Router();

let User = require("../Modules/solicitudes");

router.get("/principalSolicitante", function(req, res, next) {
  let menu = [
    { option: "Solicitudes", active: 1, href: "" },
    { option: "opcion1Solicitante", active: 0, href: "" },
    { option: "opcion2Solicitante", active: 0, href: "" },
    { option: "opcion3Solicitante", active: 0, href: "" }
  ];

  res.render("./solicitudes/principalSolicitante", {
    menu: menu,
    usuario: req.session.usuario,
    tipoUsuario: "Solicitante"
  });
});

router.get("/registrarSolicitud", function(req, res, next) {
  let menu = [
    {
      option: "Solicitudes",
      active: 1,
      href: "/solicitudes/principalSolicitante"
    },
    { option: "opcion1Solicitante", active: 0, href: "" },
    { option: "opcion2Solicitante", active: 0, href: "" },
    { option: "opcion3Solicitante", active: 0, href: "" }
  ];
  res.render("./solicitudes/registrarSolicitud", {
    menu: menu,
    usuario: req.session.usuario,
    tipoUsuario: "Solicitante"
  });
});

router.get("/detalleSolicitud", function(req, res, next) {
  let menu = [
    {
      option: "Solicitudes",
      active: 1,
      href: "/solicitudes/principalSolicitante"
    },
    { option: "opcion1Solicitante", active: 0, href: "" },
    { option: "opcion2Solicitante", active: 0, href: "" },
    { option: "opcion3Solicitante", active: 0, href: "" }
  ];
  res.render("./solicitudes/detalleSolicitud", {
    menu: menu,
    usuario: req.session.usuario,
    tipoUsuario: "Solicitante"
  });
});

module.exports = router;
