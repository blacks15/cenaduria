<?php
namespace Bussiness;

use Models\ModelEmpleado;
use App\Jwt\JWTService;
use Clases\Utileria;
use App\Log\Logger;
use Exception;

require(RUTA_MODELS.'/ModelEmpleado.php');
require(RUTA_CLASES.'/JWTService.php');

abstract class EmpleadoBussiness {
    public static function empleadoFilter(){
        Logger::log('entro metodo empleadoFilter bussiness', 4);
        $response = array();
        try {
            $response = ModelEmpleado::obtienePuestos();
            $response['generos'] = ModelEmpleado::obtieneGeneros();
        } catch(\Exception $e) {
            Logger::log("Metodo: empleadoFilter bussiness, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $response;
    }

    public static function agregarEmpelado($empleado){
        Logger::log('entro metodo agregarEmpelado bussiness', 4);
        $response = array();
        try {
            $empleado = self::sanitizeDatosEmpelado($empleado);

            $response = ModelEmpleado::guardarEmpleado($empleado);
        } catch(\Exception $e) {
            Logger::log("Metodo: agregarEmpelado bussiness, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $empleado;
    }

    private static function sanitizeDatosEmpelado($empleado){
        $empleado->nombreEmpleado = (string) Utileria::toCleanString( $empleado->nombreEmpleado );
        $empleado->snombreEmpleado = (string) Utileria::toCleanString( $empleado->snombreEmpleado );
        $empleado->apaterno = (string) Utileria::toCleanString( $empleado->apaterno );
        $empleado->amaterno = (string) Utileria::toCleanString( $empleado->amaterno );
        $empleado->fechaNac = (string) Utileria::validateDate( $empleado->fechaNac );
        $empleado->genero = Utileria::soloNumeros( $empleado->genero );
        $empleado->rfc = (string) Utileria::toCleanString( $empleado->rfc );
        $empleado->numSSocial = Utileria::soloNumeros( $empleado->numSSocial );
        $empleado->sueldo = Utileria::formatMoney( $empleado->sueldo );
        $empleado->puesto = Utileria::soloNumeros( $empleado->puesto );
        $empleado->cp = Utileria::soloNumeros( $empleado->cp );
        $empleado->coloniaText = (string) Utileria::toCleanString( $empleado->coloniaText );
        $empleado->ciudad = (string) Utileria::toCleanString( $empleado->ciudad );
        $empleado->estado = (string) Utileria::toCleanString( $empleado->estado );
        $empleado->calle = (string) Utileria::toCleanString( $empleado->calle );
        $empleado->numExt = Utileria::soloNumeros( $empleado->numExt );
        $empleado->numInt = Utileria::soloNumeros( $empleado->numInt );
        $empleado->referencia = (string) Utileria::toCleanString( $empleado->referencia );
        $empleado->tel1 = (string) Utileria::validaTel( $empleado->tel1 );
        $empleado->tel2 = (string) Utileria::validaTel( $empleado->tel2 );
        $empleado->cel = (string) Utileria::validaTel( $empleado->cel );
        $empleado->email = (string) Utileria::formatEmail( $empleado->email );
        $empleado->status = (string) Utileria::toCleanString('DISPONIBLE');

        return $empleado;
    }
}