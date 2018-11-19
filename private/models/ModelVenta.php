<?php
namespace Models;

use App\Database\Conexion;
use PDO;
use PDOStatement;
use PDOException;
use Exception;

require_once(ARCHIVO_CONECTION);

class ModelVenta {
        //QUERYS
    private $CONSULTA_USUARIO = "SELECT * FROM usuarios WHERE usuario = :1 AND id_empleado = :2";
    private $CONSULTA_USUARIOS = "SELECT * FROM usuarios";

    public function consultarUsuario($datos) {
        try {
            $db = new Conexion('mysql');
            $respuesta = array();
            
            $stm =  $db->prepare($this->CONSULTA_USUARIO);
            $stm->bindParam(":1",$datos[0],PDO::PARAM_STR);
            $stm->bindParam(":2",$datos[1],PDO::PARAM_STR);
   
            $stm->execute();
            $datos = $stm->fetch(PDO::FETCH_ASSOC);
            $error = $stm->errorInfo();
            
            $res = array("codRet" => "0000", "mensaje" => "Exito", "Datos" => $datos);
        } catch(PDOException $e){
            $res = array("codRet" => $e->getCode(), "mensaje" => $e->getMessage());
        } catch (Exception $e) {
            $res = array("codRet" => $e->getCode(), "mensaje" => $e->getMessage());
        }

        return $res;
    }
}