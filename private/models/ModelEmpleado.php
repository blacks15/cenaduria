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

abstract class ModelEmpleado {
    private static $SP_OBTIENE_PUESTOS = 'CALL spObtienePuestos(@codRetorno,@msg,@msgSQL)';
    private static $SP_OBTIENE_GENEROS = 'CALL spObtieneGeneros(@codRetorno,@msg,@msgSQL)';
    private static $SP_GUARDAR_EMPLEADO = 'CALL ';
    private static $RETORNO_SP = 'SELECT @codRetorno AS codRetorno, @msg AS mensaje, @msgSQL AS msgSQLBD';

    public static function obtienePuestos(){
        $i = 0;
        $puestos = array();
        try {
            $conn = new Conexion('mysql');

            $stm = $conn->prepare(self::$SP_OBTIENE_PUESTOS);

            $stm->execute();
            $datos = $stm->fetchAll();
            $stm->closeCursor();

            $error = $stm->errorInfo();

            if ( !empty( $error[2] ) ) {
                Logger::log('spObtienePuestos: '. Utileria::getErrorSP( $error ) , 0);
            }

            $response = $conn->query(self::$RETORNO_SP)->fetch();

            if (empty($response['codRetorno']) ) {
				return array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
            } else {
                foreach ($datos as $value) {
                    $existePuesto = Utileria::search_multiarray($value['id_puesto'], $puestos);

                    if ( !$existePuesto ) {
                        $puestos[$i] = array('idPuesto' => $value['id_puesto'],
                            'puesto' => strtoupper($value['puesto']),
                        );
                    }

                    $i++;
                }
                unset($response['msgSQLBD'], $response['mensaje']);
                $response['puestos'] = $puestos;
            }
        } catch(\PDOException $e){
            Logger::log("Metodo: obtienePerfiles, ".Utileria::getErrorMessage($e), 1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        } catch (\Exception $e) {
            Logger::log("Metodo: obtienePerfiles, ".Utileria::getErrorMessage($e), 1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL, 'mensaje' => ERROR_GENERAL ) ;
        }

        return $response;
    }

    public static function obtieneGeneros(){
        $i = 0;
        $generos = array();
        try {
            $conn = new Conexion('mysql');

            $stm = $conn->prepare(self::$SP_OBTIENE_GENEROS);

            $stm->execute();
            $datos = $stm->fetchAll();
            $stm->closeCursor();

            $error = $stm->errorInfo();

            if ( !empty( $error[2] ) ) {
                Logger::log('spObtieneGeneros: '. Utileria::getErrorSP( $error ) , 0);
            }

            $response = $conn->query(self::$RETORNO_SP)->fetch();

            if (empty($response['codRetorno']) ) {
				return array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
            } else {
                foreach ($datos as $value) {
                    $existePerfil = Utileria::search_multiarray($value['id_genero_persona'], $generos);

                    if ( !$existePerfil ) {
                        $generos[$i] = array('idGenero' => $value['id_genero_persona'],
                            'genero' => strtoupper($value['descripcion']),
                        );
                    }

                    $i++;
                }
                unset($response['msgSQLBD'], $response['mensaje'], $response['codRetorno']);
                $response = $generos;
            }
        } catch(\PDOException $e){
            Logger::log("Metodo: obtieneGeneros, ".Utileria::getErrorMessage($e), 1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        } catch (\Exception $e) {
            Logger::log("Metodo: obtieneGeneros, ".Utileria::getErrorMessage($e), 1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL, 'mensaje' => ERROR_GENERAL ) ;
        }

        return $response;
    }

    public static function guardarEmpleado($empleado){
        try {
            $conn = new Conexion('mysql');

            $stm = $conn->prepare(self::$SP_GUARDAR_EMPLEADO);

            $stm->execute();
            $datos = $stm->fetchAll();
            $stm->closeCursor();

            $error = $stm->errorInfo();

            if ( !empty( $error[2] ) ) {
                Logger::log('spGuardarEmpelados: '. Utileria::getErrorSP( $error ) , 0);
            }

            $response = $conn->query(self::$RETORNO_SP)->fetch();

            if (empty($response['codRetorno']) ) {
				return array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
            } else {
                unset($response['msgSQLBD']);
            }
        } catch(\PDOException $e){
            Logger::log("Metodo: guardarEmpleado, ".Utileria::getErrorMessage($e), 1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        } catch (\Exception $e) {
            Logger::log("Metodo: guardarEmpleado, ".Utileria::getErrorMessage($e), 1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL, 'mensaje' => ERROR_GENERAL ) ;
        }

        return $response;
    }
}