-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema revalidasyequivalencias
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `revalidasyequivalencias` ;

-- -----------------------------------------------------
-- Schema revalidasyequivalencias
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `revalidasyequivalencias` DEFAULT CHARACTER SET utf8 ;
USE `revalidasyequivalencias` ;

-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`asignatura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`asignatura` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`asignatura` (
  `idAsignatura` INT(10) UNSIGNED NOT NULL,
  `nombreAsignatura` VARCHAR(100) NOT NULL,
  `descripcionAsignatura` VARCHAR(255) NULL DEFAULT NULL,
  `unidCredito` INT(10) UNSIGNED NOT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idAsignatura`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`universidad_instituto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`universidad_instituto` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`universidad_instituto` (
  `idUniversidadInstituto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombreUI` VARCHAR(50) NOT NULL,
  `extranjera` VARCHAR(1) NOT NULL,
  `direccion` VARCHAR(255) NULL DEFAULT NULL,
  `abreviatura` VARCHAR(10) NULL DEFAULT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUniversidadInstituto`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabla para almacenar las universidades o institutos.';


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`facultad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`facultad` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`facultad` (
  `idFacultad` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idUniversidadInstituto` INT(10) UNSIGNED NOT NULL,
  `nombreFacultad` VARCHAR(50) NULL DEFAULT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idFacultad`),
  INDEX `fk_facultad_universidadInstituto_idx` (`idUniversidadInstituto` ASC),
  CONSTRAINT `fk_facultad_universidadInstituto`
    FOREIGN KEY (`idUniversidadInstituto`)
    REFERENCES `revalidasyequivalencias`.`universidad_instituto` (`idUniversidadInstituto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`escuela`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`escuela` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`escuela` (
  `idEscuela` INT(10) UNSIGNED NOT NULL,
  `idFacultad` INT(10) UNSIGNED NOT NULL,
  `nombreEscuela` VARCHAR(50) NULL DEFAULT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idEscuela`),
  INDEX `fk_escuela_facultad_idx` (`idFacultad` ASC),
  CONSTRAINT `fk_escuela_facultad`
    FOREIGN KEY (`idFacultad`)
    REFERENCES `revalidasyequivalencias`.`facultad` (`idFacultad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`carrera` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`carrera` (
  `idCarrera` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEscuela` INT(10) UNSIGNED NOT NULL,
  `nombreCarrera` VARCHAR(50) NULL DEFAULT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idCarrera`),
  INDEX `fk_carrera_escuela_idx` (`idEscuela` ASC),
  CONSTRAINT `fk_carrera_escuela`
    FOREIGN KEY (`idEscuela`)
    REFERENCES `revalidasyequivalencias`.`escuela` (`idEscuela`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`asignaturascarrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`asignaturascarrera` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`asignaturascarrera` (
  `idCarrera` INT(10) UNSIGNED NOT NULL,
  `idAsignatura` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`idCarrera`, `idAsignatura`),
  INDEX `fk_asigcarrera_asignatura_idx` (`idAsignatura` ASC),
  INDEX `fk_asigcarrera_carrera_idx` (`idCarrera` ASC),
  CONSTRAINT `fk_asigcarrera_asignatura`
    FOREIGN KEY (`idAsignatura`)
    REFERENCES `revalidasyequivalencias`.`asignatura` (`idAsignatura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asigcarrera_carrera`
    FOREIGN KEY (`idCarrera`)
    REFERENCES `revalidasyequivalencias`.`carrera` (`idCarrera`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`usuario` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`usuario` (
  `cedula` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido` VARCHAR(50) NOT NULL,
  `lugarDeNacimiento` VARCHAR(50) NOT NULL,
  `nacionalidad` VARCHAR(1) NOT NULL,
  `fechaDeNacimiento` DATE NOT NULL,
  `sexo` VARCHAR(1) NOT NULL,
  `direccion` VARCHAR(255) NULL DEFAULT NULL,
  `telefono` VARCHAR(12) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `contrasena` TEXT NOT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cedula`))
ENGINE = InnoDB
AUTO_INCREMENT = 1111112
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabla para almacenar los usuarios del sistema';


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`asignaturasequivalentes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`asignaturasequivalentes` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`asignaturasequivalentes` (
  `nroComprobante` INT(10) UNSIGNED NOT NULL,
  `idAsignaturaA` INT(10) UNSIGNED NOT NULL,
  `idAsignaturaE` INT(10) UNSIGNED NOT NULL,
  `cedula` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`nroComprobante`, `idAsignaturaA`, `idAsignaturaE`, `cedula`),
  INDEX `fk_asigEquivalente_asignatura_idx` (`idAsignaturaA` ASC),
  INDEX `fk_asigEquivalente_asignaturaEquivalente_idx` (`idAsignaturaE` ASC),
  INDEX `fk_asigEquivalente_solicitante_idx` (`cedula` ASC),
  CONSTRAINT `fk_asigEquivalente_asignatura`
    FOREIGN KEY (`idAsignaturaA`)
    REFERENCES `revalidasyequivalencias`.`asignatura` (`idAsignatura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asigEquivalente_asignaturaEquivalente`
    FOREIGN KEY (`idAsignaturaE`)
    REFERENCES `revalidasyequivalencias`.`asignatura` (`idAsignatura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asigEquivalente_solicitante`
    FOREIGN KEY (`cedula`)
    REFERENCES `revalidasyequivalencias`.`usuario` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`solicitud`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`solicitud` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`solicitud` (
  `idSolicitud` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCarreraP` INT(10) UNSIGNED NOT NULL,
  `idCarreraC` INT(10) UNSIGNED NOT NULL,
  `cedula` INT(10) UNSIGNED NOT NULL,
  `facultadP` VARCHAR(50) NULL DEFAULT NULL,
  `escuelaP` VARCHAR(50) NULL DEFAULT NULL,
  `carreraP` VARCHAR(50) NULL DEFAULT NULL,
  `facultadC` VARCHAR(50) NULL DEFAULT NULL,
  `escuelaC` VARCHAR(50) NULL DEFAULT NULL,
  `carreraC` VARCHAR(50) NULL DEFAULT NULL,
  `procedencia` VARCHAR(1) NULL DEFAULT NULL,
  `otros` VARCHAR(1) NULL DEFAULT NULL,
  `descripcionOtros` VARCHAR(255) NULL DEFAULT NULL,
  `certiNotas` VARCHAR(1) NULL DEFAULT NULL,
  `copiaTitulo` VARCHAR(1) NULL DEFAULT NULL,
  `pensum` VARCHAR(1) NULL DEFAULT NULL,
  `prograEstudios` VARCHAR(1) NULL DEFAULT NULL,
  `cedula_Pasaporte` VARCHAR(1) NULL DEFAULT NULL,
  `certifi_Categoria` VARCHAR(1) NULL DEFAULT NULL,
  `certifiNoTitulo` VARCHAR(1) NULL DEFAULT NULL,
  `traduccion` VARCHAR(1) NULL DEFAULT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idSolicitud`),
  INDEX `fk_solicitud_carreraCursar_idx` (`idCarreraC` ASC),
  INDEX `fk_solicitud_carreraProce_idx` (`idCarreraP` ASC),
  INDEX `fk_solicitud_solicitante_idx` (`cedula` ASC),
  CONSTRAINT `fk_solicitud_carreraCursar`
    FOREIGN KEY (`idCarreraC`)
    REFERENCES `revalidasyequivalencias`.`carrera` (`idCarrera`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_carreraProce`
    FOREIGN KEY (`idCarreraP`)
    REFERENCES `revalidasyequivalencias`.`carrera` (`idCarrera`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_solicitante`
    FOREIGN KEY (`cedula`)
    REFERENCES `revalidasyequivalencias`.`usuario` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Tabla para almacenar las solicitudes de equivalencia.';


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`comprobante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`comprobante` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`comprobante` (
  `nroComprobante` INT(10) UNSIGNED NOT NULL,
  `idSolicitud` INT(10) UNSIGNED NOT NULL,
  `observaciones` VARCHAR(1024) NULL DEFAULT NULL,
  `fechaSubComisionEq` DATE NULL DEFAULT NULL,
  `fechaComisionEq` DATE NULL DEFAULT NULL,
  `fechaConFacul` DATE NULL DEFAULT NULL,
  `fechaConUnive` DATE NULL DEFAULT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nroComprobante`),
  INDEX `fk_comprobante_solicitud_idx` (`idSolicitud` ASC),
  CONSTRAINT `fk_comprobante_solicitud`
    FOREIGN KEY (`idSolicitud`)
    REFERENCES `revalidasyequivalencias`.`solicitud` (`idSolicitud`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`periodoacademico`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`periodoacademico` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`periodoacademico` (
  `idPeriodoAcademico` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idFacultad` INT(10) UNSIGNED NOT NULL,
  `idUniversidadInstituto` INT(10) UNSIGNED NOT NULL,
  `nombre` VARCHAR(10) NOT NULL,
  `descripcion` VARCHAR(512) NOT NULL,
  `decano` VARCHAR(100) NOT NULL,
  `repSubEquiUno` VARCHAR(100) NOT NULL,
  `repSubEquiDos` VARCHAR(100) NOT NULL,
  `repSubEquiTres` VARCHAR(100) NOT NULL,
  `repComiEquiUno` VARCHAR(100) NOT NULL,
  `repComiEquiDos` VARCHAR(100) NOT NULL,
  `repComiEquiTres` VARCHAR(100) NOT NULL,
  `borrado` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idPeriodoAcademico`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`personaladmre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`personaladmre` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`personaladmre` (
  `cedula` INT(10) UNSIGNED NOT NULL,
  `idPersonalADMRE` INT(10) UNSIGNED NOT NULL,
  `idFacultad` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`cedula`),
  UNIQUE INDEX `idPersonalADMRE_UNIQUE` (`idPersonalADMRE` ASC),
  INDEX `fk_personaladmre_usuario_idx` (`cedula` ASC),
  INDEX `fk_personaladmre_facultad_idx` (`idFacultad` ASC),
  CONSTRAINT `fk_personaladmre_facultad`
    FOREIGN KEY (`idFacultad`)
    REFERENCES `revalidasyequivalencias`.`facultad` (`idFacultad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_personaladmre_usuario`
    FOREIGN KEY (`cedula`)
    REFERENCES `revalidasyequivalencias`.`usuario` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`personalire`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`personalire` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`personalire` (
  `cedula` INT(10) UNSIGNED NOT NULL,
  `idPersonalIRE` INT(10) UNSIGNED NOT NULL,
  `idFacultad` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`cedula`),
  UNIQUE INDEX `idPersonalIRE_UNIQUE` (`idPersonalIRE` ASC),
  INDEX `fk_personalire_usuario_idx` (`cedula` ASC),
  INDEX `fk_personalire_facultad_idx` (`idFacultad` ASC),
  CONSTRAINT `fk_personalire_facultad`
    FOREIGN KEY (`idFacultad`)
    REFERENCES `revalidasyequivalencias`.`facultad` (`idFacultad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_personalire_usuario`
    FOREIGN KEY (`cedula`)
    REFERENCES `revalidasyequivalencias`.`usuario` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`solicitante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`solicitante` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`solicitante` (
  `cedula` INT(10) UNSIGNED NOT NULL,
  `idSolicitante` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`cedula`),
  UNIQUE INDEX `idSolicitante_UNIQUE` (`idSolicitante` ASC),
  INDEX `fk_solicitante_usuario_idx` (`cedula` ASC),
  CONSTRAINT `fk_solicitante_usuario`
    FOREIGN KEY (`cedula`)
    REFERENCES `revalidasyequivalencias`.`usuario` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`statussolicitud`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`statussolicitud` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`statussolicitud` (
  `idStatus` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombreStatus` VARCHAR(50) NULL DEFAULT NULL,
  `descripcion` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idStatus`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`solicitud_tiene_statussolicitud`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`solicitud_tiene_statussolicitud` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`solicitud_tiene_statussolicitud` (
  `idStatus` INT(10) UNSIGNED NOT NULL,
  `idSolicitud` INT(10) UNSIGNED NOT NULL,
  `fechaEfectiva` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`idStatus`, `idSolicitud`),
  INDEX `fk_solicitudStatus_solicitud_idx` (`idSolicitud` ASC),
  INDEX `fk_solicitudStatus_statusSolicitud_idx` (`idStatus` ASC),
  CONSTRAINT `fk_solicitudStatus_solicitud`
    FOREIGN KEY (`idSolicitud`)
    REFERENCES `revalidasyequivalencias`.`solicitud` (`idSolicitud`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitudStatus_statusSolicitud`
    FOREIGN KEY (`idStatus`)
    REFERENCES `revalidasyequivalencias`.`statussolicitud` (`idStatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `revalidasyequivalencias`.`superadmre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `revalidasyequivalencias`.`superadmre` ;

CREATE TABLE IF NOT EXISTS `revalidasyequivalencias`.`superadmre` (
  `cedula` INT(10) UNSIGNED NOT NULL,
  `idSuperADMRE` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`cedula`),
  UNIQUE INDEX `idSuperADMRE_UNIQUE` (`idSuperADMRE` ASC),
  INDEX `fk_superadmre_usuario_idx` (`cedula` ASC),
  CONSTRAINT `fk_superadmre_usuario`
    FOREIGN KEY (`cedula`)
    REFERENCES `revalidasyequivalencias`.`usuario` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `revalidasyequivalencias` ;

-- -----------------------------------------------------
-- function fun_existeCedula
-- -----------------------------------------------------

USE `revalidasyequivalencias`;
DROP function IF EXISTS `revalidasyequivalencias`.`fun_existeCedula`;

DELIMITER $$
USE `revalidasyequivalencias`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fun_existeCedula`(
	prm_cedula INT
) RETURNS int(11)
BEGIN
	RETURN (SELECT 11 FROM usuario WHERE cedula = prm_cedula AND borrado = 0);
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function fun_getTipoUsuario
-- -----------------------------------------------------

USE `revalidasyequivalencias`;
DROP function IF EXISTS `revalidasyequivalencias`.`fun_getTipoUsuario`;

DELIMITER $$
USE `revalidasyequivalencias`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fun_getTipoUsuario`(
	prm_cedula INT,
    prm_tipoUsuario INT
) RETURNS int(11)
BEGIN
	CASE prm_tipoUsuario
		WHEN 1 THEN
			RETURN (SELECT 1 FROM personaladmre WHERE cedula = prm_cedula);
		WHEN 2 THEN
			RETURN (SELECT 1 FROM personalire WHERE cedula = prm_cedula);
		WHEN 3 THEN
			RETURN (SELECT 1 FROM solicitante WHERE cedula = prm_cedula);
    END CASE;

END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure usp_crearUsuario
-- -----------------------------------------------------

USE `revalidasyequivalencias`;
DROP procedure IF EXISTS `revalidasyequivalencias`.`usp_crearUsuario`;

DELIMITER $$
USE `revalidasyequivalencias`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_crearUsuario`(
	prm_cedula INT,
    prm_nombre VARCHAR(50),
    prm_apellido VARCHAR(50),
    prm_lugarDeNacimiento VARCHAR(50),
    prm_nacionalidad VARCHAR(1),
    prm_fechaDeNacimiento VARCHAR(10),
    prm_sexo VARCHAR(1),
    prm_direccion VARCHAR(255),
    prm_telefono VARCHAR(12),
    prm_correo VARCHAR(100),
    prm_contrasena TEXT,
    prm_tipousuario INT,
    prm_idfacultad INT
)
BEGIN
	DECLARE auxFecha DATE;
    DECLARE existeCedula INT;
    DECLARE esTipoUsuario INT;
    DECLARE idTipoUsuario INT;

    SET existeCedula = (SELECT fun_existeCedula(prm_cedula));

    IF(existeCedula IS NULL)THEN
		SET auxFecha = (SELECT DATE_FORMAT(STR_TO_DATE(prm_fechaDeNacimiento, '%d/%m/%Y'), '%Y-%m-%d'));

        INSERT INTO usuario
			(cedula, nombre, apellido, lugarDeNacimiento, nacionalidad, fechaDeNacimiento, sexo, direccion, telefono, correo, contrasena)
		VALUES
			(prm_cedula, prm_nombre, prm_apellido, prm_lugarDeNacimiento, prm_nacionalidad, auxFecha, prm_sexo, prm_direccion, prm_telefono, prm_correo, prm_contrasena);

        SET esTipoUsuario = (SELECT fun_getTipoUsuario(prm_cedula, prm_tipousuario));

        CASE prm_tipousuario
			WHEN 1 THEN
				IF(esTipoUsuario IS NULL)THEN
					SET idTipoUsuario = (SELECT COUNT(cedula) + 1 FROM personaladmre);
					INSERT INTO personaladmre (cedula, idFacultad, idPersonalADMRE) VALUES (prm_cedula, prm_idfacultad, idTipoUsuario);
					SELECT '0' codigo, 'Usuario registrado exitosamente' mensaje;
                ELSE
					SELECT '1' codigo, 'El portador de la cedula ya esta registrado como personal administrativo de revalidas y equivalencias';
                END IF;
			WHEN 2 THEN
				IF(esTipoUsuario IS NULL)THEN
					SET idTipoUsuario = (SELECT COUNT(cedula) + 1 FROM idPersonalIRE);
					INSERT INTO personalire (cedula, idFacultad, idPersonalIRE) VALUES (prm_cedula, prm_idfacultad);
					SELECT '0' codigo, 'Usuario registrado exitosamente' mensaje;
                ELSE
					SELECT '2' codigo, 'El portador de la cedula ya esta registrado como personal interno de revalidas y equivalencias';
                END IF;
			WHEN 3 THEN
				IF(esTipoUsuario IS NULL)THEN
					SET idTipoUsuario = (SELECT COUNT(cedula) + 1 FROM solicitante);
					INSERT INTO solicitante (cedula, idSolicitante) VALUES (prm_cedula, idTipoUsuario);
					SELECT '0' codigo, 'Usuario registrado exitosamente' mensaje;
                ELSE
					SELECT '3' codigo, 'El portador de la cedula ya esta registrado como solicitante';
                END IF;
        END CASE;
        COMMIT;
	ELSE
        SET esTipoUsuario = (SELECT fun_getTipoUsuario(prm_cedula, prm_tipousuario));
        CASE prm_tipousuario
			WHEN 1 THEN
				IF(esTipoUsuario IS NULL)THEN
					SET idTipoUsuario = (SELECT COUNT(cedula) + 1 FROM personaladmre);
					INSERT INTO personaladmre (cedula, idFacultad, idPersonalADMRE) VALUES (prm_cedula, prm_idfacultad, idTipoUsuario);
					SELECT '0' codigo, 'Usuario registrado exitosamente' mensaje;
                ELSE
					SELECT '1' codigo, 'El portador de la cedula ya esta registrado como personal administrativo de revalidas y equivalencias';
                END IF;
			WHEN 2 THEN
				IF(esTipoUsuario IS NULL)THEN
					SET idTipoUsuario = (SELECT COUNT(cedula) + 1 FROM personalire);
					INSERT INTO personalire (cedula, idFacultad, idPersonalIRE) VALUES (prm_cedula, prm_idfacultad, idTipoUsuario);
					SELECT '0' codigo, 'Usuario registrado exitosamente' mensaje;
                ELSE
					SELECT '2' codigo, 'El portador de la cedula ya esta registrado como personal interno de revalidas y equivalencias';
                END IF;
			WHEN 3 THEN
				IF(esTipoUsuario IS NULL)THEN
					SET idTipoUsuario = (SELECT COUNT(cedula) + 1 FROM solicitante);
					INSERT INTO solicitante (cedula, idSolicitante) VALUES (prm_cedula, idTipoUsuario);
					SELECT '0' codigo, 'Usuario registrado exitosamente' mensaje;
                ELSE
					SELECT '3' codigo, 'El portador de la cedula ya esta registrado como solicitante';
                END IF;
		END CASE;
        COMMIT;
    END IF;
END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
