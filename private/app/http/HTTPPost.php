<?php
namespace app\http;

class HTTPPost {
    private static $method = "::index";

    public static function filter($request){
        try {
                //CLASE
            $clase = "Controller".trim($request['opc']);
                //RUTA DEL CONTROLADOR
            $rutaController = RUTA_CONTROLLERS."/".$clase.".php";;
                //SI EL ARCHIVO DEL CONTROLADOR EXISTE CONTINUAMOS CON LA CLASE
            if (file_exists($rutaController)) {
                    //METODO
                self::$method = trim($request['action']);
                    //INCLUIR EL CONTROLADOR
                include($rutaController);
                    //CREAR INSTANCÍA DEL CONTROLADOR
                $nameSpace = "Controllers\\".$clase;
            
                $controller = new $nameSpace;
                    //EJECUTA EL METODO
                $method = self::$method;
                $response = (method_exists($controller,self::$method)) ? $controller->$method() : call_user_func(self::class.self::$method);
            } else { //SI NO EXISTE EL CONTROLADOR REGRESAMOS EL ERROR POR DEFECTO
                $response = call_user_func( self::class.self::$method );
            }
        } catch(Exception $e){
            $response = call_user_func( self::class.self::$method );            
        }
        return $response;
    }

    public static function index(){
        return array("codRetorno" => "002", "mensaje" => ERROR_GENERAL);
    }
}