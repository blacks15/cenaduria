<?php
    use app\http\HTTPPost;
    
    header("Access-Control-Allow-Origin: *");
    header('content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, X-CLIENT-ID, X-CLIENT-SECRET');
    header('Access-Control-Allow-Credentials: true');
    
    require_once( dirname(__DIR__).'/app/rutas.php' );
    require_once(RUTA_HTTP."/HTTPPost.php");
    require_once(RUTA_CLASES.'/Mensajes.php');
    require_once(RUTA_CLASES.'/Constantes.php');

    print ( json_encode( HTTPPost::filter($_REQUEST) ) );