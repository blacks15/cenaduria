<?php
namespace App\Database;

use Clases\Utileria;
use App\Log\Logger;
use Exception;
use PDO;

class Conexion extends PDO {
    private $conn;
    private $tipo_de_base;
    private $host;
    private $nombre_de_base;
    private $usuario;
    private $contrasena;
    private $port;
    private $error;

	public function __construct($dbname) {
        $this->getConf($dbname);
        try {
            parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena);
            parent::setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            parent::setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch(\PDOException $e){
            Logger::log("Metodo: conexionBD, ".Utileria::getErrorMessage($e->getMessage() ), 0);
            throw new Exception($e, 1);
        }
    }

    private function __clone(){}

    private function getConf($dbname) {
        $conf = parse_ini_file(ARCHIVO_INI,true);
            //CARGAR CONFIGURACIÓN DEFAULT
        if (is_null($dbname) || empty($dbname)) {
            $this->tipo_de_base = $conf['database']['driver'];
            $this->host = $conf['database']['server'];
            $this->nombre_de_base = $conf['database']['db'];
            $this->usuario = $conf['database']['user'];
            $this->contrasena = $conf['database']['password'];
            $this->port = $conf['database']['port'];
        } else {
            $this->tipo_de_base = $conf[$dbname]['driver'];
            $this->host = $conf[$dbname]['server'];
            $this->nombre_de_base = $conf[$dbname]['db'];
            $this->usuario = $conf[$dbname]['user'];
            $this->contrasena = $conf[$dbname]['password'];
            $this->port = $conf[$dbname]['port'];  
        }
    }
}
