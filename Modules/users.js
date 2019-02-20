let conn = require("./connectionMysql");
var bcrypt = require("bcrypt-nodejs");
let userModule = {};

userModule.registrarSolicitante = function(input, callback) {
  if (conn) {
    let query = "CALL usp_crearUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    conn.query(
      query,
      [
        input.cedula,
        input.nombres,
        input.apellidos,
        input.lugarDeNacimiento,
        input.nacionalidad,
        input.fechaDeNacimiento,
        input.sexo,
        input.direccion,
        input.telefono,
        input.correo,
        bcrypt.hashSync(input.contrasena),
        input.tipoUsuario,
        input.idFacultad
      ],
      function(err, rows) {
        try {
          if (err) {
            console.log("Error in stored procedure usp_crearUsuario: " + err);
            callback(err, null);
          } else {
            callback(err, rows[0]);
          }
        } catch (e) {
          callback(err, null);
        }
      }
    );
  } else {
    console.log("No connection with database");
  }
};

userModule.iniciarSesion = function(input, callback) {
  if (conn) {
    let query = "CALL usp_iniciarSesion(?)";
    conn.query(query, [input.cedula], function(err, rows) {
      try {
        if (err) {
          console.log("Error in stored procedure: " + err);
          callback(err, null);
        } else {
          if (rows[0][0].contrasena) {
            if (bcrypt.compareSync(input.contrasena, rows[0][0].contrasena)) {
              let auxUsuario = JSON.parse(JSON.stringify(rows[0][0]) || "{}");
              auxUsuario.tipoUsuario = {
                solicitante: auxUsuario.solicitante,
                personalIRE: auxUsuario.personalIRE,
                personalAdm: auxUsuario.personalAdm,
                superAdmin: auxUsuario.superAdmin
              };
              callback(null, auxUsuario);
            } else {
              let error = {
                codigo: 1,
                mensaje: "Cedula o contrasena invalidas"
              };
              callback(null, error);
            }
          } else {
            let error = {
              codigo: 1,
              mensaje: "Cedula o contrasena invalidas"
            };
            callback(null, error);
          }
        }
      } catch (err) {
        console.log("Error in response post processing: " + err);
        callback(err, null);
      }
    });
  } else {
    console.log("No connection with database");
  }
};

userModule.editarDatosPersonales = function(input, callback) {
  if (conn) {
    let query = "CALL usp_editarDatosPersonales(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    conn.query(
      query,
      [
        input.cedula,
        input.nombres,
        input.apellidos,
        input.lugarDeNacimiento,
        input.nacionalidad,
        input.fechaDeNacimiento,
        input.sexo,
        input.direccion,
        input.telefono,
        input.correo
      ],
      function(err, rows) {
        try {
          if (err) {
            console.log(
              "Error in stored procedure editarDatosPersonales: " + err
            );
            callback(err, null);
          } else {
            callback(err, rows[0]);
          }
        } catch (e) {
          callback(err, null);
        }
      }
    );
  } else {
    console.log("No connection with database");
  }
};

userModule.cambiarContrasena = function(input, callback) {
  // if (rows[0][0].contrasena) {
  if (bcrypt.compareSync(input.antiguaContrasena, input.contrasenaActual)) {
    let nuevaContrasena = bcrypt.hashSync(input.nuevaContrasena);
    if (conn) {
      let query = "CALL usp_cambiarContrasena(?, ?);";
      conn.query(query, [input.cedula, nuevaContrasena], function(err, rows) {
        try {
          if (err) {
            console.log(
              "Error in stored procedure usp_cambiarContrasena: " + err
            );
            callback(err, null);
          } else {
            let data = {
              codigo: 0,
              mensaje: "Su contrasena se cambio exitosamente",
              nuevaContrasena: nuevaContrasena
            };
            callback(null, data);
          }
        } catch (e) {
          callback(err, null);
        }
      });
    } else {
      console.log("No connection with database");
    }
  } else {
    let error = {
      codigo: 1,
      mensaje: "Su antigua contrasena no es correcta"
    };
    callback(null, error);
  }
};
module.exports = userModule;
