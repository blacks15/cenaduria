<?php
namespace Controllers;

use Bussiness\EmpleadoBussiness;
use Clases\Utileria;
use App\Log\Logger;
use utf8_encode;
use Exception;

require(RUTA_LOG.'/Logger.php');
require(RUTA_CLASES.'/Utileria.php');
require(RUTA_BUSSINESS.'/EmpleadoBussiness.php');
/*
    AUTOR: Felipe Monzón Mendoza
    FECHA: 10-JULIO-2018
    DESCRIPCIÓN: Controller para el Modulo de Empleados
*/
class ControllerEmpleado {
    public function filter(){
        Logger::log('entro metodo empleado filter', 4);
        $response = array();
        try {
            $response = EmpleadoBussiness::empleadoFilter();
        } catch(\Exception $e){
            Logger::log("Metodo: empleado filter, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $response;
    }

    public function guardar(){
        Logger::log('entro metodo guardar empleado', 4);
        $response = array();
        $validaCampos = array();
        $empleado = new \stdClass();
        try {
            $empleado = json_decode( trim($_POST['cadena']) );

            array_push($validaCampos, $empleado->nombreEmpleado );
            array_push($validaCampos, $empleado->apaterno );
            array_push($validaCampos, $empleado->amaterno );
            array_push($validaCampos, $empleado->fechaNac );
            array_push($validaCampos, $empleado->sueldo );
            array_push($validaCampos, $empleado->puesto );
            array_push($validaCampos, $empleado->genero );
            array_push($validaCampos, $empleado->cp );
            array_push($validaCampos, $empleado->coloniaText );
            array_push($validaCampos, $empleado->ciudad );
            array_push($validaCampos, $empleado->estado );
            array_push($validaCampos, $empleado->calle );
            array_push($validaCampos, $empleado->numExt );

            if ( Utileria::validaFields($empleado) && Utileria::isEmpty($validaCampos) || Utileria::validarCorreo($empleado->email) ) {
                return array('codRetorno' => COD_RETORNO_PARAM_VACIOS, 'titulo' => 'Advertencia', 'mensaje' => ERROR_GENERAL );
                Logger::log('Metodo: guardar empleado, Codigo: '.$response['codRetorno'].' Mensaje: '.PARAMETROS_VACIOS, 3);
            }

            $response = EmpleadoBussiness::agregarEmpelado($empleado);
            $response = array('codRetorno' => '000', 'mensaje' => 'Empleado Guardado con Exito');
        } catch(\Exception $e){
            Logger::log("Metodo: guardar empleado, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $empleado;
    }
}
