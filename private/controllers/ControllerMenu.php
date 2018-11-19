<?php
namespace Controllers;

use App\Jwt\JWTService;
use Clases\Utileria;
use App\Log\Logger;
use Bussiness\MenuBussiness;
use utf8_encode;
use Exception;

require_once(RUTA_LOG.'/Logger.php');
require_once(RUTA_CLASES.'/Utileria.php');
require_once(RUTA_CLASES.'/JWTService.php');
require_once(RUTA_BUSSINESS.'/MenuBussiness.php');
/*
    AUTOR: Felipe Monzón Mendoza
    FECHA: 13-JUNIO-2018
    DESCRIPCIÓN: Controller para Obtener Menú Mediante el Perfil
*/
class ControllerMenu {
    public function menu(){
        Logger::log('entro metodo menu', 4);
        $response = array();
        try {
            $datos = json_decode( trim($_POST['cadena']) );

            $jwtService = ( isset($datos->jwt) && !is_null($datos->jwt) ) ? JWTService::checkJWT($datos->jwt) : call_user_func( __NAMESPACE__ .'\ControllerMenu::index' );

            if ( !isset($jwtService['codRetorno']) ) {
                $response = MenuBussiness::obtieneMenu($jwtService['tipo'],$jwtService['nombre']);
            } else {
                $response = $jwtService;
            }
        } catch(\Exception $e){
            Logger::log("Metodo: menu, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $response;
    }

    public function subMenu(){
        Logger::log('entro metodo submenu', 4);
        $response = array();
        try {
            $datos = json_decode( trim($_POST['cadena']) );

            $jwtService = ( isset($datos->jwt) ) ? JWTService::checkJWT($datos->jwt) : call_user_func( __NAMESPACE__ .'\ControllerMenu::index' );

            if ( !isset($jwtService['codRetorno']) ) {
                $response = MenuBussiness::obtieneSubMenu($jwtService['tipo'],$datos->idMenu);
            } else {
                $response = $jwtService;
            }

        } catch(\Exception $e){
            Logger::log("Metodo: menu, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $response;
    }

    public static function index(){
        return array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
    }
}