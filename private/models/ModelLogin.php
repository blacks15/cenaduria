<?php
namespace Models;

use App\Database\Conexion;
use Clases\Utileria;
use App\Log\Logger;

use PDO;
use PDOStatement;
use PDOException;
use Exception;

require_once(ARCHIVO_CONECTION);

abstract class ModelLogin {
    privAte static $SP_OBTIENE_USUARIO = "CALL spValidaUsuario(:perfil,@codRetorno,@msg,@msgSQL)";
    private static $RETORNO_SP = 'SELECT @codRetorno AS codRetorno, @msg AS mensaje, @msgSQL AS msgSQLBD';

    public static function consultarUsuario($datos) {
        try {
            //$db = new Conexion('mysql');
            
            if ($datos->usuario == 'felipe') {
                $response = array('nombre_usuario' => 'felipe',
                    'matricula_empleado' => '3312',
                    'nombreEmpleado' => strtoupper('felipe monzon'),
                    'perfil' => '1',
                    'codRetorno' => COD_RETORNO_EXITO
                );
            } else {
                $response = array('codRetorno' => '001', 'mensaje' => ERROR_LOGIN);
            }
        } catch(\PDOException $e){
            Logger::log("Metodo: consultarUsuario, ".Utileria::getErrorMessage($e),1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        } catch (\Exception $e) {
            Logger::log("Metodo: consultarUsuario, ".Utileria::getErrorMessage($e),1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        }

        return $response;
    }
}