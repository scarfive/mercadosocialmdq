--
--     estructure.sql
--
--     ARCHIVO QUE CONTIENE A ESTRUCTURA DE LA BASE DE DATOS
--
--     Created on : 17/04/2015, 15:42:06
--     Author     : Juan Manuel Scarciofolo
--     License    : GPLv3
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `apellido` varchar(64) COLLATE latin1_spanish_ci DEFAULT '',
  `nombre` varchar(64) COLLATE latin1_spanish_ci DEFAULT '',
  `apodo` varchar(32) COLLATE latin1_spanish_ci DEFAULT '',
  `domicilio` varchar(64) COLLATE latin1_spanish_ci DEFAULT '',
  `telefono` varchar(16) COLLATE latin1_spanish_ci DEFAULT '',
  `zona` int(11) NOT NULL DEFAULT '1',
  `correo` varchar(64) COLLATE latin1_spanish_ci DEFAULT '',
  `alta` datetime DEFAULT NULL,
  `clave` varchar(64) COLLATE latin1_spanish_ci DEFAULT '',
  `imagen` varchar(256) COLLATE latin1_spanish_ci DEFAULT '',
  `conexion` datetime DEFAULT NULL,
   PRIMARY KEY (`codigo`),
   INDEX (`apellido`),
   INDEX (`nombre`),
   INDEX (`apodo`),
   INDEX (`domicilio`),
   INDEX (`zona`),
   INDEX (`alta`),
   INDEX (`conexion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `productos` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) COLLATE latin1_spanish_ci DEFAULT '',
  `precio` double(8,2) unsigned NOT NULL DEFAULT '0',
  `resumen` text COLLATE latin1_spanish_ci,
  `usuario` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`codigo`),
   INDEX (`descripcion`),
   INDEX (`precio`),
   INDEX (`usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `categorias` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) COLLATE latin1_spanish_ci DEFAULT '',
   PRIMARY KEY (`codigo`),
   INDEX (`descripcion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `cat_productos` (
  `producto` int(11) unsigned NOT NULL DEFAULT '0',
  `categoria` int(11) unsigned NOT NULL DEFAULT '0',
   INDEX (`producto`),
   INDEX (`categoria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `img_productos` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `producto` int(11) unsigned NOT NULL DEFAULT '0',
  `imagen` varchar(256) COLLATE latin1_spanish_ci DEFAULT '',
   PRIMARY KEY (`codigo`),
   INDEX (`producto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `publicaciones` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `producto` int(11) unsigned NOT NULL DEFAULT '0',
  `precio` double(8,2) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `limite` datetime DEFAULT NULL,
  `vistas` int(11) unsigned NOT NULL DEFAULT '0',
  `activa` boolean NOT NULL DEFAULT FALSE,
   PRIMARY KEY (`codigo`),
   INDEX (`producto`),
   INDEX (`precio`),
   INDEX (`fecha`),
   INDEX (`limite`),
   INDEX (`vistas`),
   INDEX (`activa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `publicaciones_canceladas` (
  `codigo` int(11) unsigned NOT NULL DEFAULT '0',
  `producto` int(11) unsigned NOT NULL DEFAULT '0',
  `precio` double(8,2) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `limite` datetime DEFAULT NULL,
  `vistas` int(11) unsigned NOT NULL DEFAULT '0',
  `activa` boolean NOT NULL DEFAULT FALSE,
   PRIMARY KEY (`codigo`),
   INDEX (`producto`),
   INDEX (`precio`),
   INDEX (`fecha`),
   INDEX (`limite`),
   INDEX (`vistas`),
   INDEX (`activa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `operaciones` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `monto` double(8,2) unsigned NOT NULL DEFAULT '0',
  `publicacion` int(11) unsigned NOT NULL DEFAULT '0',
  `comprador` int(11) unsigned NOT NULL DEFAULT '0',
  `concretada` boolean NOT NULL DEFAULT FALSE,
   PRIMARY KEY (`codigo`),
   INDEX (`fecha`),
   INDEX (`publicacion`),
   INDEX (`comprador`),
   INDEX (`concretada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `operaciones_canceladas` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `monto` double(8,2) unsigned NOT NULL DEFAULT '0',
  `publicacion` int(11) unsigned NOT NULL DEFAULT '0',
  `comprador` int(11) unsigned NOT NULL DEFAULT '0',
  `concretada` boolean NOT NULL DEFAULT FALSE,
   PRIMARY KEY (`codigo`),
   INDEX (`fecha`),
   INDEX (`publicacion`),
   INDEX (`comprador`),
   INDEX (`concretada`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `puntajes` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `operacion` int(11) unsigned NOT NULL DEFAULT '0',
  `de` int(11) unsigned NOT NULL DEFAULT '0',
  `para` int(11) unsigned NOT NULL DEFAULT '0',
  `puntaje` int(11) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `observaciones` varchar(256) COLLATE latin1_spanish_ci DEFAULT '',
   PRIMARY KEY (`codigo`),
   INDEX (`operacion`),
   INDEX (`de`),
   INDEX (`para`),
   INDEX (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `preguntas` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `publicacion` int(11) unsigned NOT NULL DEFAULT '0',
  `usuario` int(11) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `pregunta` varchar(256) COLLATE latin1_spanish_ci DEFAULT '',
  `respondida` boolean NOT NULL DEFAULT FALSE,
   PRIMARY KEY (`codigo`),
   INDEX (`publicacion`),
   INDEX (`usuario`),
   INDEX (`fecha`),
   INDEX (`respondida`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `respuestas` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pregunta` int(11) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `respuesta` varchar(256) COLLATE latin1_spanish_ci DEFAULT '',
   PRIMARY KEY (`codigo`),
   INDEX (`pregunta`),
   INDEX (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `comentarios` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `producto` int(11) unsigned NOT NULL DEFAULT '0',
  `usuario` int(11) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `comentario` varchar(256) COLLATE latin1_spanish_ci DEFAULT '',
   PRIMARY KEY (`codigo`),
   INDEX (`producto`),
   INDEX (`usuario`),
   INDEX (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `calificaciones` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `producto` int(11) unsigned NOT NULL DEFAULT '0',
  `usuario` int(11) unsigned NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT NULL,
  `calificacion` int(11) unsigned NOT NULL DEFAULT '0',
  `observaciones` VARCHAR(256) COLLATE latin1_spanish_ci DEFAULT '',
   PRIMARY KEY (`codigo`),
   INDEX (`producto`),
   INDEX (`usuario`),
   INDEX (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `mensajes` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `de` int(11) unsigned NOT NULL DEFAULT '0',
  `para` int(11) unsigned NOT NULL DEFAULT '0',
  `mensaje` varchar(256) COLLATE latin1_spanish_ci DEFAULT '',
  `leido` boolean NOT NULL DEFAULT FALSE,
   PRIMARY KEY (`codigo`),
   INDEX (`fecha`),
   INDEX (`de`),
   INDEX (`para`),
   INDEX (`leido`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


CREATE TABLE IF NOT EXISTS `zonas` (
  `codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zona` varchar(64) COLLATE latin1_spanish_ci DEFAULT '',
   PRIMARY KEY (`codigo`),
   INDEX (`zona`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
