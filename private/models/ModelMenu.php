<?php
namespace Models;

use App\Log\Logger;
use Clases\Utileria;
use App\Database\Conexion;

use PDO;
use PDOStatement;
use PDOException;
use Exception;

require_once(ARCHIVO_CONECTION);

abstract class ModelMenu {
    privAte static $SP_OBTIENE_MENU = "CALL spObtenerMenu(:perfil,@codRetorno,@msg,@msgSQL)";
    privAte static $SP_OBTIENE_SUBMENU = "CALL spObtenerSubMenu(:perfil,:idMenu,@codRetorno,@msg,@msgSQL)";
    private static $RETORNO_SP = 'SELECT @codRetorno AS codRetorno, @msg AS mensaje, @msgSQL AS msgSQLBD';

    public static function consultaMenu($perfil){
        $i = 0;
        $conn = null;
        $padre = array();
        $menu = array();
        try {
            $conn = new Conexion('mysql');

            $stm = $conn->prepare(self::$SP_OBTIENE_MENU);
            $stm->bindParam(':perfil',$perfil,PDO::PARAM_INT);

            $stm->execute();
            $datos = $stm->fetchAll();
            $stm->closeCursor();

            $error = $stm->errorInfo();

            if ( !empty( $error[2] ) ) {
                Logger::log('spObtenerMenu: '. Utileria::getErrorSP( $error ) , 0);
            }

            $response = $conn->query(self::$RETORNO_SP)->fetch();

            if (empty($response['codRetorno'])  ) {
				return array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
            } else {
                foreach ($datos as $value) {
                    $existePadre = Utileria::search_multiarray($value['id_padre'],$padre );
                    $exitseMenu = Utileria::search_multiarray($value['id_menu'], $menu);

                    if ( !$existePadre ) {
                        $padre[$i] = array('id_padre' => $value['id_padre'],
                            'padre' => $value['padre'],
                            'icono'=> $value['icono']
                        );
                    }

                    if ( !$exitseMenu ) {
                        $menu[$i] = array('idMenu' => $value['id_menu'],
                            'menu' => $value['menu'],
                            'idPadre' => $value['id_padre']
                        );
                    }

                    $i++;
                }
                unset($response['msgSQLBD']);
                $response['menuPadre'] = $padre;
                $response['menu'] = $menu;
            }
        } catch(\PDOException $e){
            Logger::log("Metodo: consultarMenu, ".Utileria::getErrorMessage($e),1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        } catch (\Exception $e) {
            Logger::log("Metodo: consultarMenu, ".Utileria::getErrorMessage($e),1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        }   

        return $response;
    }

    public static function consultaSubMenu($perfil,$idMenu){
        $i = 0;
        $menu = array();
        try {
            $conn = new Conexion('mysql');

            $stm = $conn->prepare(self::$SP_OBTIENE_SUBMENU);
            $stm->bindParam(':perfil',$perfil,PDO::PARAM_INT);
            $stm->bindParam(':idMenu',$idMenu,PDO::PARAM_INT);

            $stm->execute();
            $datos = $stm->fetchAll();
            $stm->closeCursor();

            $error = $stm->errorInfo();

            if ( !empty( $error[2] ) ) {
                Logger::log('spObtenerSubMenu: '. Utileria::getErrorSP( $error ) , 0);
            }

            $response = $conn->query(self::$RETORNO_SP)->fetch();

            if (empty($response['codRetorno'])  ) {
				return array("codRetorno" => COD_RETORNO_ERROR_GENERAL, "mensaje" => ERROR_GENERAL);
            } else {
                foreach ($datos as $value) {
                    $exitseMenu = Utileria::search_multiarray($value['id_submenu'], $menu);

                    if ( !$exitseMenu ) {
                        $menu[$i] = array('idSubMenu' => $value['id_submenu'],
                            'subMenu' => ucfirst($value['subMenu']),
                            'opcion' => $value['subMenu'].ucfirst( $value['menu'] )
                        );
                    }

                    $i++;
                }
                unset($response['msgSQLBD']);
                $response['subMenu'] = $menu;
            }
        } catch(\PDOException $e){
            Logger::log("Metodo: consultaSubMenu, ".Utileria::getErrorMessage($e),1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        } catch (\Exception $e) {
            Logger::log("Metodo: consultaSubMenu, ".Utileria::getErrorMessage($e),1);
            $response = array( 'codRetorno' => COD_RETORNO_ERROR_GENERAL , 'mensaje' => ERROR_GENERAL ) ;
        }

        return $response;
    }
}