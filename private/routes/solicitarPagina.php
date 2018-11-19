<?php
    header("Content-Type: text/html");
    
    require_once( dirname(__DIR__).'/app/rutas.php' );
    require(RUTA_HTTP."/HTTPGet.php");
    
    use app\http\HTTPGet;
    
    HTTPGet::View($_GET );
