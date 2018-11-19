-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2018 a las 01:40:47
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `spring`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`syssav`@`localhost` PROCEDURE `spObtenerMenu` (IN `pPerfil` BIGINT, OUT `codRetorno` CHAR(3), OUT `msg` VARCHAR(100), OUT `msgSQL` VARCHAR(100))  BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
		@errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
		SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
		SET msgSQL = @full_error;
		SET codRetorno = '002';
		RESIGNAL;
		ROLLBACK;
	END; 
	DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
		@errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
		SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
		SET msgSQL = @full_error;
		SET codRetorno = '002';
		SHOW WARNINGS LIMIT 1;
		RESIGNAL;
		ROLLBACK;
	END;
			SET codRetorno = '000';
	SET msgSQL = '';
	SET msg = '';

	IF (pPerfil = 0) THEN
		SET codRetorno = '004';
		SET msg = 'Parametros Vacios';
	ELSE
		SELECT mp.id_padre, mp.descripcion AS padre, mp.icono, m.id_menu, m.descripcion AS menu
        FROM adm_menu_perfil admp
        INNER JOIN menu_padre mp ON mp.id_padre = admp.id_padre
        INNER JOIN menus m ON m.id_menu = admp.id_menu
        INNER JOIN perfiles p ON p.id_perfil = admp.id_perfil
        WHERE admp.id_perfil = pPerfil;
	END IF;
END$$

CREATE DEFINER=`syssav`@`localhost` PROCEDURE `spObtenerSubMenu` (IN `pPerfil` BIGINT, IN `pIdMenu` BIGINT, OUT `codRetorno` CHAR(3), OUT `msg` VARCHAR(100), OUT `msgSQL` VARCHAR(100))  BEGIN
            DECLARE numFila INTEGER;

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
		@errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
		SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
		SET msgSQL = @full_error;
		SET codRetorno = '002';
		RESIGNAL;
		ROLLBACK;
	END; 
	DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
		@errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
		SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
		SET msgSQL = @full_error;
		SET codRetorno = '002';
		SHOW WARNINGS LIMIT 1;
		RESIGNAL;
		ROLLBACK;
	END;
        	SET codRetorno = '000';
	SET msgSQL = '';
	SET msg = '';

	IF (pPerfil = 0 OR pIdMenu = 0) THEN
		SET codRetorno = '004';
		SET msg = 'Parametros Vacios';
	ELSE
        SELECT COUNT(*)
        INTO numFila
        FROM adm_menu_perfil
        WHERE id_perfil = pPerfil
            AND id_menu = pIdMenu;

        IF ( numFila IS NOT NULL OR numFila > 0) THEN
            SELECT m.id_menu, m.descripcion AS menu, sbm.id_submenu, sbm.descripcion AS subMenu
            FROM adm_menu_perfil admp
            INNER JOIN menu_padre mp ON mp.id_padre = admp.id_padre
            INNER JOIN menus m ON m.id_menu = admp.id_menu
            INNER JOIN perfiles p ON p.id_perfil = admp.id_perfil
            INNER JOIN submenus sbm ON sbm.id_submenu = admp.id_submenu
            WHERE admp.id_perfil = pPerfil 
                AND admp.id_menu = pIdMenu;
        ELSE
            SET codRetorno = '001';
		    SET msg = 'No se Encontrarón Resultados';
        END IF;
	END IF;
END$$

CREATE DEFINER=`syssav`@`localhost` PROCEDURE `spObtieneGeneros` (OUT `codRetorno` CHAR(3), OUT `msg` VARCHAR(100), OUT `msgSQL` VARCHAR(100))  BEGIN
    DECLARE filas INT;
	
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
            SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
            SET msgSQL = @full_error;
            SET codRetorno = '002';
            RESIGNAL;
            ROLLBACK;
        END; 
    DECLARE EXIT HANDLER FOR SQLWARNING
        BEGIN
            GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
            SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
            SET msgSQL = @full_error;
            SET codRetorno = '002';
            SHOW WARNINGS LIMIT 1;
            RESIGNAL;
            ROLLBACK;
        END;
			SET codRetorno = '000';
	SET msgSQL = '';
	SET msg = '';

    SELECT COUNT(id_genero_persona) INTO filas FROM genero_persona;

    IF (filas = 0) THEN
        SET codRetorno = '001';
        SET msg = 'No hay Registros para Mostrar';
    ELSE
        SELECT id_genero_persona,descripcion
        FROM genero_persona;
        SET msg = 'SP ejecutado correctamente';
    END IF;
END$$

CREATE DEFINER=`syssav`@`localhost` PROCEDURE `spObtienePerfiles` (OUT `codRetorno` CHAR(3), OUT `msg` VARCHAR(100), OUT `msgSQL` VARCHAR(100))  BEGIN
    DECLARE filas INT;
	
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
            SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
            SET msgSQL = @full_error;
            SET codRetorno = '002';
            RESIGNAL;
            ROLLBACK;
        END; 
    DECLARE EXIT HANDLER FOR SQLWARNING
        BEGIN
            GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
            SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
            SET msgSQL = @full_error;
            SET codRetorno = '002';
            SHOW WARNINGS LIMIT 1;
            RESIGNAL;
            ROLLBACK;
        END;
			SET codRetorno = '000';
	SET msgSQL = '';
	SET msg = '';

    SELECT COUNT(id_perfil) INTO filas FROM perfiles;

    IF (filas = 0) THEN
        SET codRetorno = '001';
        SET msg = 'No hay Registros para Mostrar';
    ELSE
        SELECT id_perfil,descripcion
        FROM perfiles;
        SET msg = 'SP ejecutado correctamente';
    END IF;
END$$

CREATE DEFINER=`syssav`@`localhost` PROCEDURE `spObtienePuestos` (OUT `codRetorno` CHAR(3), OUT `msg` VARCHAR(100), OUT `msgSQL` VARCHAR(100))  BEGIN
    DECLARE filas INT;
	
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
            SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
            SET msgSQL = @full_error;
            SET codRetorno = '002';
            RESIGNAL;
            ROLLBACK;
        END; 
    DECLARE EXIT HANDLER FOR SQLWARNING
        BEGIN
            GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
            SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
            SET msgSQL = @full_error;
            SET codRetorno = '002';
            SHOW WARNINGS LIMIT 1;
            RESIGNAL;
            ROLLBACK;
        END;
			SET codRetorno = '000';
	SET msgSQL = '';
	SET msg = '';

    SELECT COUNT(id_puesto) INTO filas FROM puestos;

    IF (filas = 0) THEN
        SET codRetorno = '001';
        SET msg = 'No hay Registros para Mostrar';
    ELSE
        SELECT id_puesto, puesto
        FROM puestos;
        SET msg = 'SP ejecutado correctamente';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_menu_perfil`
--

CREATE TABLE `adm_menu_perfil` (
  `id_padre` bigint(20) NOT NULL,
  `id_menu` bigint(20) NOT NULL,
  `id_submenu` bigint(20) NOT NULL,
  `id_perfil` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `adm_menu_perfil`
--

INSERT INTO `adm_menu_perfil` (`id_padre`, `id_menu`, `id_submenu`, `id_perfil`) VALUES
(1, 1, 1, 1),
(1, 1, 2, 1),
(1, 2, 1, 1),
(1, 2, 2, 1),
(1, 6, 1, 1),
(2, 14, 1, 1),
(2, 14, 4, 2),
(2, 15, 1, 1),
(2, 15, 3, 2),
(3, 3, 1, 1),
(3, 4, 1, 1),
(3, 7, 1, 1),
(3, 8, 2, 1),
(3, 9, 1, 1),
(3, 9, 2, 1),
(4, 5, 1, 1),
(4, 13, 1, 1),
(5, 11, 1, 1),
(5, 11, 1, 2),
(5, 12, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero_persona`
--

CREATE TABLE `genero_persona` (
  `id_genero_persona` bigint(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `genero_persona`
--

INSERT INTO `genero_persona` (`id_genero_persona`, `descripcion`) VALUES
(1, 'masculino'),
(2, 'femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` bigint(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id_menu`, `descripcion`) VALUES
(1, 'productos'),
(2, 'categorias'),
(3, 'cajas'),
(4, 'sucursales'),
(5, 'sistema compras'),
(6, 'marcas'),
(7, 'empleados'),
(8, 'clientes'),
(9, 'proveedores'),
(10, 'usuarios'),
(11, 'punto venta'),
(12, 'ventas diarias'),
(13, 'compras diarias'),
(14, 'apertura caja'),
(15, 'corte caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_padre`
--

CREATE TABLE `menu_padre` (
  `id_padre` bigint(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `icono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu_padre`
--

INSERT INTO `menu_padre` (`id_padre`, `descripcion`, `icono`) VALUES
(1, 'inventario', 'archive'),
(2, 'caja', 'laptop'),
(3, 'adm recurso', 'address-card'),
(4, 'compra', 'dollar-sign'),
(5, 'Venta', 'shopping-cart');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` bigint(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `descripcion`) VALUES
(1, 'administrador'),
(2, 'cajero'),
(3, 'comprador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` bigint(20) NOT NULL,
  `puesto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id_puesto`, `puesto`) VALUES
(1, 'pa-tron'),
(2, 'jefe sucursal'),
(3, 'comprador'),
(4, 'vendedor'),
(5, 'cajero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submenus`
--

CREATE TABLE `submenus` (
  `id_submenu` bigint(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `submenus`
--

INSERT INTO `submenus` (`id_submenu`, `descripcion`) VALUES
(1, 'agregar'),
(2, 'consultar'),
(3, 'corte caja'),
(4, 'apertura caja'),
(5, 'reportes');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adm_menu_perfil`
--
ALTER TABLE `adm_menu_perfil`
  ADD PRIMARY KEY (`id_menu`,`id_submenu`,`id_perfil`),
  ADD KEY `adm_menu_perfil_submenus_fk` (`id_submenu`),
  ADD KEY `adm_menu_perfil_perfiles_fk` (`id_perfil`),
  ADD KEY `adm_menu_perfil_menu_padre_fk` (`id_padre`);

--
-- Indices de la tabla `genero_persona`
--
ALTER TABLE `genero_persona`
  ADD PRIMARY KEY (`id_genero_persona`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `menu_padre`
--
ALTER TABLE `menu_padre`
  ADD PRIMARY KEY (`id_padre`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`);

--
-- Indices de la tabla `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`id_submenu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `genero_persona`
--
ALTER TABLE `genero_persona`
  MODIFY `id_genero_persona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `menu_padre`
--
ALTER TABLE `menu_padre`
  MODIFY `id_padre` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `submenus`
--
ALTER TABLE `submenus`
  MODIFY `id_submenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adm_menu_perfil`
--
ALTER TABLE `adm_menu_perfil`
  ADD CONSTRAINT `adm_menu_perfil_menu_padre_fk` FOREIGN KEY (`id_padre`) REFERENCES `menu_padre` (`id_padre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adm_menu_perfil_menus_fk` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adm_menu_perfil_perfiles_fk` FOREIGN KEY (`id_perfil`) REFERENCES `perfiles` (`id_perfil`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adm_menu_perfil_submenus_fk` FOREIGN KEY (`id_submenu`) REFERENCES `submenus` (`id_submenu`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
