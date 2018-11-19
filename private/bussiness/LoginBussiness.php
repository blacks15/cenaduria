<?php
namespace Bussiness;

use Models\ModelLogin;
use App\Jwt\JWTService;
use Clases\Utileria;
use App\Log\Logger;
use Exception;

require(RUTA_MODELS.'/ModelLogin.php');
require(RUTA_CLASES.'/JWTService.php');

session_start();

abstract class LoginBussiness {
    public static function validaLogin($login){
        $response = array();
        try {
            if (!isset($_SESSION['intentos']) ) {
				$_SESSION['intentos'] = 0; 
				$_SESSION['usuario'] = $login->usuario; 
			} else if ($_SESSION['intentos'] > 3 && $_SESSION['usuario'] == $login->usuario) {
                LoginModel::bloquearUsuario($login->usuario);
				$response['mensaje'] = USUARIO_BLOQUEADO;
				return $response;
				exit();
            }
            
            $datosUsuario = ModelLogin::consultarUsuario($login);

            if ( $datosUsuario['codRetorno'] == COD_RETORNO_EXITO ) {
                $jwt = JWTService::createJWT($datosUsuario);

                $decode = JWTService::checkJWT($jwt['jwt']);

                $response = array('codRetorno' => COD_RETORNO_EXITO,
                    'jwt' => $jwt['jwt'],
                    'titulo' => 'Bienvenido',
                    'mensaje'=> $datosUsuario['nombreEmpleado'],
                );
            } else {
                $response = $datosUsuario;
                self::validaIntentos($login->usuario );
            }
        } catch(\Exception $e){
            Logger::log("Metodo: login, ".Utileria::getErrorMessage($e->getMessage() ),1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }

        return $response;
    }

    private static function validaPassword($password,$usuario){
        $isValido = false;
        try {
            $password = filter_var($password,FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES|FILTER_FLAG_ENCODE_AMP);
            
            if (!empty($password)) {
                if ( crypt($password,$usuario['password']) == $usuario['password'] ) {
                    $isValido = true;
                }
            }
        } catch(\Exception $e){
            Logger::log("Metodo: validaPassword, ".Utileria::getErrorMessage($e->getMessage() ),1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
        return $isValido;
    }

    private static function validaIntentos($usuario){
        try {
            if ($_SESSION['usuario'] == $usuario) {
                $_SESSION['intentos'] += 1;
                $_SESSION['usuario'] = $usuario;
            } else {
                $_SESSION['intentos'] = 1;
				$_SESSION['usuario'] = $usuario;
            }
        } catch(\Exception $e){
            Logger::log("Metodo: validaPassword, ".Utileria::getErrorMessage($e), 1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }
    }
}