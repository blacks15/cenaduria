<?php
namespace App\Jwt;

require(RUTA_JWT.'/autoload.php');

use \Firebase\JWT\JWT;
use Clases\Utileria;
use App\Log\Logger;
use Exception;

abstract class JWTService {
    private static $encrypt = ['HS256']; //HS256
    private static $aud = null;
    private static $JWT = "";
    private static $key = "";
    private static $token = array();

    public static function checkJWT($token){
        $JWTProperties = self::getRutaKey();
        $decode = "";
        try {
            if ( is_null($token) || !isset($token) || empty($token) ) {
                $response = array('codRetorno' => COD_RETORNO_JWT,
					'titulo' => 'Advertencia',
                    'mensaje' => ERROR_GENERAL
                );
            }
            self::$key = base64_encode( $JWTProperties['key'] );

            $decode = JWT::decode($token,self::$key,self::$encrypt);

            self::$token = array('id' => base64_decode($decode->id ),
                'usuario' => base64_decode($decode->usuario),
                'nombre' => base64_decode($decode->empleado),
                'tipo' => base64_decode($decode->tipo),
                'expiredTime' => $decode->expiredTime,
                'aud' => $decode->aud
            );

            if ( $decode->aud !== self::Aud() ) {
                $response = array('codRetorno' => COD_RETORNO_JWT,
					'titulo' => 'Advertencia',
                    'mensaje' => ERROR_GENERAL
                );
            } else {
                $response = self::$token;
            }
        } catch(\Exception $e){
            Logger::log("Metodo: checkJWT, ".$e->getMessage() ,1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }

        return $response;
    }

    public static function createJWT($data) {
        $JWTProperties = self::getRutaKey();
        $time = time();
        $time = $time + strtotime( $JWTProperties['time'] );
        try {
            self::$token = array('id' => base64_encode($data['matricula_empleado']),
                'usuario' => base64_encode($data['nombre_usuario']),
                'empleado' => base64_encode($data['nombreEmpleado']),
                'tipo' => base64_encode($data['perfil']),
                'expiredTime' => $time,
                'aud' => self::Aud()
            );

            self::$key = base64_encode( $JWTProperties['key'] );

            self::$JWT = JWT::encode(self::$token,self::$key);

            $response = array('jwt' => self::$JWT);
        } catch(\Exception $e){
            Logger::log("Metodo: createJWT, ".Utileria::getError($e->getMessage() ),1);
            $response = array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
        }

        return $response;
    }

    private static function getRutaKey(){
        $JWTProperties = parse_ini_file(ARCHIVO_INI,true);
        return $JWTProperties['jwt'];
    }

    private static function Aud() {
        try {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                self::$aud = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                self::$aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                self::$aud = $_SERVER['REMOTE_ADDR'];
            }

            self::$aud.= @$_SERVER['HTTP_USER_AGENT'];
            self::$aud.= gethostname();

        } catch(\Exception $e){
            print($e->getMessage());
        }

        return sha1(self::$aud);
    }
}