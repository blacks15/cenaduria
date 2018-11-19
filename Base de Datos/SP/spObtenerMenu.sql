DROP PROCEDURE IF EXISTS spObtenerMenu;

DELIMITER $$
CREATE DEFINER='syssav'@'localhost' PROCEDURE spObtenerMenu (
	IN pPerfil BIGINT,
	OUT codRetorno CHAR(3),
	OUT msg VARCHAR(100),
	OUT msgSQL VARCHAR(100)
)
-- =====================================================================
-- Author:       	Felipe Monzón Mendoza
-- Create date: 	27/Jun/2018
-- Description:   	Procedimiento para obtener el menu del la aplicación
--                  dependiendo del perfil
-- =====================================================================
BEGIN
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
		-- DECLARACIÓN DE VARIABLES
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
DELIMITER ;