DROP PROCEDURE IF EXISTS spObtieneGeneros;

DELIMITER $$
CREATE DEFINER='syssav'@'localhost' PROCEDURE spObtieneGeneros (
	OUT codRetorno CHAR(3),
	OUT msg VARCHAR(100),
	OUT msgSQL VARCHAR(100)
)
-- =====================================================================
-- Author:       	Felipe Monzón Mendoza
-- Create date: 	27/Jun/2018
-- Description:   	Procedimiento para obtener los generos del usuario
-- =====================================================================
BEGIN
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
		-- DECLARACIÓN DE VARIABLES
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
DELIMITER ;