DROP PROCEDURE IF EXISTS spObtenerSubMenu;

DELIMITER $$
CREATE DEFINER='syssav'@'localhost' PROCEDURE spObtenerSubMenu (
	IN pPerfil BIGINT,
    IN pIdMenu BIGINT,
	OUT codRetorno CHAR(3),
	OUT msg VARCHAR(100),
	OUT msgSQL VARCHAR(100)
)
-- =====================================================================
-- Author:       	Felipe Monzón Mendoza
-- Create date: 	05/Jul/2018
-- Description:   	Procedimiento para obtener el subMenu del la aplicación
--                  dependiendo del perfil
-- =====================================================================
BEGIN
        -- DECLARACIÓN DE VARIABLES
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
        -- INICIALIZACION DE VARIABLES
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
DELIMITER ;