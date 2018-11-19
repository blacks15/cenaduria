<?php
namespace Bussiness;

use Models\ModelMenu;
use Clases\Utileria;
use App\Log\Logger;

use Exception;

require(RUTA_MODELS.'/ModelMenu.php');

abstract class MenuBussiness {
    public static function obtieneMenu($perfil, $usuario){
        Logger::log('entro metodo menu bussiness', 2);

        $response = array();
        try {
            $perfil = (int) Utileria::soloNumeros($perfil);

            if ( !isset($perfil) || empty($perfil) ) {
                $response = array('codRetorno' => COD_RETORNO_PARAM_VACIOS,
                    'titulo' => 'Advertencia',
                    'mensaje' => ERROR_GENERAL
                );
                Logger::log('Metodo: obtieneMenu, Codigo: '.$response['codRetorno'].' Mensaje: '.PARAMETROS_VACIOS, 3);
                return $response;
            }
            
            $response = ModelMenu::consultaMenu($perfil);

            if ($response['codRetorno'] == COD_RETORNO_EXITO) {
                $response['usuario'] = $usuario;
            }
        } catch(\Exception $e) {
            Logger::log("Metodo: obtieneMenu, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $response;
    }

    public static function obtieneSubMenu($perfil,$idMenu){
        Logger::log('entro metodo obtieneSubMenu bussiness', 2);
        $response = array();
        try {
            $perfil = (int) Utileria::soloNumeros($perfil);
            $idMenu = (int) Utileria::soloNumeros($idMenu);

            if ( !isset($perfil,$idMenu) || empty($perfil) || empty($idMenu) ) {
                $response = array('codRetorno' => COD_RETORNO_PARAM_VACIOS,
                    'titulo' => 'Advertencia',
                    'mensaje' => ERROR_GENERAL
                );
                Logger::log('Metodo: obtieneSubMenu, Codigo: '.$response['codRetorno'].' Mensaje: '.PARAMETROS_VACIOS, 3);
                return $response;
            }
            
            $response = ModelMenu::consultaSubMenu($perfil,$idMenu);
        } catch(\Exception $e) {
            Logger::log("Metodo: obtieneSubMenu, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $response;
    }
}