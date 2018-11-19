<?php
namespace App\Log;
/*
    CLASE PARA ESCRIBIR LOGS DESDE PHP
*/

abstract class Logger {
    private static $status = array('critical','error','info','warning','debug');    
    private static $logdir = RUTA_SAVE_LOG;
    private static $logExt = ".log";  
    private static $separator = "\n";  
    private static $filehandler = false;  

    public static function log($str,$type){
        if (!self::$filehandler) {
            self::createFile();
        }

        self::writeFile($str, $type);
    }  

    private static function createFile(){
        $folder = self::$logdir.DIRECTORY_SEPARATOR;
        $file = $folder.self::getLogName();

        if (!is_dir($folder)) {
			mkdir($folder, 0777);		
		}
		
        self::$filehandler = fopen($file,'a+');

        if (!self::$filehandler) {
            die("Error: no se pudo generar el fichero");
        }

        return;
    }

    private static function writeFile($string,$type){
        $string = self::getPrefix($type)." ".$string;
        fwrite(self::$filehandler,$string.self::$separator);
        self::$filehandler = false;
    }
    
    private static function getLogName(){
        return 'log-'.date("o-M-d").self::$logExt;
    }

    private static function getPrefix($type){
        $prefix = '';
        $prefix.= "[".date("d-M-o H:i:s")."] [".self::getType($type)."] [".self::getIP()."]";
        return $prefix;
    }

    private static function getType($type)	{
		return self::$status[$type < 0 || $type > 4 ? 1:$type];
    }
    
	private static function getIP(){
		return ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;
	}

    function __destruct(){
        if (!self::$filehandler) return;
        fclose(self::$filehandler);    //CLOSE THE FILE HANDLER
    }
}
