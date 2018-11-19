<?php
        //CARPETAS
    define('ROOT',dirname( dirname(__DIR__) ));
    define('ROOT_PATH', ROOT.DIRECTORY_SEPARATOR.'private');
    define('RUTA_PUBLIC', ROOT.DIRECTORY_SEPARATOR.'public');
    define('RUTA_SISTEMA',ROOT_PATH.'/app');
    define('RUTA_ROUTES',ROOT_PATH.'/routes');
    define('RUTA_VIEWS',ROOT_PATH.'/views');
    define('RUTA_CONF',ROOT_PATH.'/config');
    define('RUTA_CLASES',ROOT_PATH.'/clases');
    define('RUTA_MODELS',ROOT_PATH.'/models');
    define('RUTA_CONTROLLERS',ROOT_PATH.'/controllers');
    define('RUTA_BUSSINESS',ROOT_PATH.'/bussiness');
    define('RUTA_RECURSOS',ROOT_PATH.'/resources');
    define('RUTA_IMGS',RUTA_RECURSOS.'/images');
    define('RUTA_JWT',RUTA_SISTEMA.'/jwt');
    define('RUTA_LOG',RUTA_SISTEMA.'/log');
    define('RUTA_HTTP',RUTA_SISTEMA.'/http');
    define('RUTA_XML',RUTA_SISTEMA.'/routesviews');
    define('RUTA_ERRORES',ROOT.'/errores');
    define('RUTA_SAVE_LOG', ROOT.'/LOG');
    define('RUTA_PUBLIC_IMAGES',RUTA_PUBLIC.'/resources/images ');
        //ARCHIVOS
    define('ARCHIVO_INI',ROOT.'/env.ini');
    define('ARCHIVO_XML',RUTA_XML.'/views.xml');
    define('ARCHIVO_CONECTION',RUTA_SISTEMA.'/database/Conexion.php');
        //LIBRERIAS
    define('ARCHIVO_DOMPDF',RUTA_SISTEMA.'/dompdf/autoload.inc.php');
    define('ARCHIVO_EXCEL',RUTA_SISTEMA.'/SimpleExcel/SimpleExcel.php');