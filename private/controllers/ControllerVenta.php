<?php
namespace Controllers;

use Models\ModelVenta;
use Clases\Utileria;
use App\Log\Logger;
use Exception;
use utf8_encode;

require(RUTA_LOG.'/Logger.php');
require(RUTA_CLASES."/Utileria.php");
require(RUTA_MODELS."/ModelVenta.php");

class ControllerVenta {
    public function iniciarVenta() {
        Logger::log("iniciarVenta",4);
        try {
            $datos[] = $_POST['usuario'];
            $datos[] = $_POST['numEmp'];
            
            $response = array();
    
            $modelVenta = new ModelVenta();
    
            $response = $modelVenta->consultarUsuario($datos);
        } catch(\Exception $e) {
            Logger::log("iniciarVenta: ".Utileria::getErrorMessage($e->getMessage() ),1);
            $response = array(Utileria::getErrorMessage($e->getMessage()) ) ;
        }

        return $response;
    }
    
    public function obtenerImagen() {
        $image = Utileria::getFileBase64(RUTA_IMGS."/goku.jpg");

        $content = '<html>';
        $content .= '<head>';
        $content .= '<style>';
        $content .= '.saltoPagina{page-break-after: always;}';
        $content .=     '.table{width:300px;margin:0 auto;}'. 
                        '.table > thead tr{background: #003366;'.
                        'color: #fff;'.
                        'font-size: 16px;}';
        $content .=     '.table{border-collapse:collapse;}';
        $content .= '</style>';
        $content .= '</head>'.
                        '<body>';
        $content.=          '<table class="table">';
        $content.=              '<thead>';
        $content.=                  '<tr>';
        $content.=                      '<td>Nombre</td>';
        $content.=                      '<td>Apellido</td>';
        $content.=                      '<td>Edad</td>';
        $content.=                  '</tr>';
        $content.=              '</thead>';
        $content.=              '<tr>';
        $content.=                  '<td>Paul</td>';
        $content.=                  '<td>Quintero</td>';
        $content.=                  '<td>25</td>';
        $content.=              '</tr>';
        $content.=          '</table>';
        $content.=          '<div class="saltoPagina"></div>';
        $content.=          '<table class="table">';
        $content.=              '<thead>';
        $content.=                  '<tr>';
        $content.=                      '<td>Nombre</td>';
        $content.=                      '<td>Apellido</td>';
        $content.=                      '<td>Edad</td>';
        $content.=                  '</tr>';
        $content.=              '</thead>';
        $content.=              '<tr>';
        $content.=                  '<td>Paul</td>';
        $content.=                  '<td>Quintero</td>';
        $content.=                  '<td>25</td>';
        $content.=              '</tr>';
        $content.=          '</table>';
        $content .=         '<p>Hola Mundo!</p>';
        $content .=     '</body>
                    </html>';

        $pdf =  Utileria::createPDF($content,"prueba",RUTA_CONTROLLERS);
                            
        $arrayCsv = array(
            array("Nombre","Apellido", "Edad"),
            array("Paul","Quintero", "25"),
            array("Alonzo","Ramirez", "25")
        );
        $pdf = Utileria::createExcel("Ejemplo",$arrayCsv,"xls",";",RUTA_PUBLIC_IMAGES);
        $response = array("codRet" => "000", "Mensaje" => "Imagen Descargada", "Imagen" => $image, "Archivo" => $pdf);
        return $response;
    }


}