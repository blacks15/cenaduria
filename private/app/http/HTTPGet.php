<?php
namespace app\http;

use SimpleXMLElement;

class HTTPGet {
    private static $error = RUTA_ERRORES."/frm404.html";

    public static function View($request){
        //VALIDAR OPCIÓN
        if (isset($request['ventana']) && $request['ventana'] != 'home') {
            try {
                $ventana = (string) $request['ventana'];
        
                $rutaConfig = ARCHIVO_XML;
        
                $xml = new SimpleXMLElement($rutaConfig,null,true);
        
                if (!isset($xml->$ventana)) {
                    include(self::$error);
                } else {
                        //RECORREMOS EL XML PARA OBTENER LA RUTA DE LA VISTA
                    foreach ($xml->$ventana as $nodo) {
                        $form = $nodo->attributes();
                        $form = $form['form'];
                    }
                        //VALIDAR QUE EL CONTROLLADOR EXISTA
                    if ((is_null($form) || empty($form))){
                        include($this->error);
                    } else {
                        if ( file_exists(ROOT.DIRECTORY_SEPARATOR.$form) ) {
                            $view = ROOT.DIRECTORY_SEPARATOR.$form;
                        } else {
                            $view = (file_exists(RUTA_VIEWS."/".$form)) ? RUTA_VIEWS.$form : self::$error;
                        }
                        include($view);
                    }
                }
            } catch(\Exception $e){
                return $e;
            }
        } else {
            include(RUTA_VIEWS."/frmHome.html");
        }
    }
}