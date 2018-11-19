DROP PROCEDURE IF EXISTS spObtienePuestos;

DELIMITER $$
CREATE DEFINER='syssav'@'localhost' PROCEDURE spObtienePuestos (
	OUT codRetorno CHAR(3),
	OUT msg VARCHAR(100),
	OUT msgSQL VARCHAR(100)
)
-- =====================================================================
-- Author:       	Felipe Monzón Mendoza
-- Create date: 	12/Jul/2018
-- Description:   	Procedimiento para obtener los puestos de empleado
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