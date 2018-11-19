<?php
namespace Controllers;

use Bussiness\LoginBussiness;
use Clases\Utileria;
use App\Log\Logger;
use utf8_encode;
use Exception;

require(RUTA_LOG.'/Logger.php');
require(RUTA_CLASES.'/Utileria.php');
require(RUTA_BUSSINESS.'/LoginBussiness.php');
/*
    AUTOR: Felipe Monzón Mendoza
    FECHA: 12-MAYO-2018
    DESCRIPCIÓN: Controller para Inicio de Session
*/
class ControllerLogin {
    public function login(){
        Logger::log('entro metodo login', 4);
        $response = array();
        $login = new \stdClass();
        try {
            $login = json_decode( trim($_POST['cadena']) );

            $login->usuario = Utileria::limpiarCadenaLogin($login->usuario);
            $login->password = Utileria::limpiarCadenaLogin($login->password);

            if ( Utileria::validaFields($login) && Utileria::isEmpty($login) ) {
                $response = array('codRetorno' => COD_RETORNO_PARAM_VACIOS,
					'titulo' => 'Advertencia',
                    'mensaje' => ERROR_GENERAL
                );
                Logger::log('Metodo: login, Codigo: '.$response['codRetorno'].' Mensaje: '.PARAMETROS_VACIOS, 3);
                return $response;
            }

            $response = LoginBussiness::validaLogin($login);

        } catch(\Exception $e){
            Logger::log("Metodo: login, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $response;
    }
}