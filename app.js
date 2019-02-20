var createError = require("http-errors");
var express = require("express");
var path = require("path");
var cookieParser = require("cookie-parser");
const bodyParser = require("body-parser");
var logger = require("morgan");
var helmet = require("helmet"); //seguridad
var session = require("express-session");

var userRouter = require("./routes/users");
var solicitudesRouter = require("./routes/solicitudes");

var app = express();

// view engine setup
app.set("views", path.join(__dirname, "views"));
app.set("view engine", "jade");

app.use(helmet());
app.use(logger("dev"));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, "public")));

app.use(
  session({
    secret: "revalidasyequivalenciasJEAM",
    saveUninitialized: true,
    resave: true
  })
);

app.use(function(req, res, next) {
  // mi middleware
  let sinAutorizacion = ["", "registrarme", "opcion1", "opcion2"];
  url = req.originalUrl.split("/");
  url = url[url.length - 1];
  // console.log(url);
  if (sinAutorizacion.includes(url)) {
    console.log("*************Parametros de entrada: " + url);
    console.log(req.body);
    next();
  } else {
    if (req.session.usuario) {
      console.log("*************Parametros de entrada: " + url);
      console.log(req.body);
      next();
    } else {
      // res.sendStatus(401);
      res.redirect("/");
    }
  }
});

app.use("/", userRouter);
app.use("/solicitudes", solicitudesRouter);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  next(createError(404));
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get("env") === "development" ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render("error");
});

module.exports = app;
