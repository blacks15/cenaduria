<?php
namespace Clases;

use DateTime;
use stdClass;
use Dompdf\Dompdf;
use SimpleExcel\SimpleExcel;

require_once(ARCHIVO_DOMPDF);
require_once(ARCHIVO_EXCEL);

abstract class Utileria{
    public function getConf() {
        return parse_ini_file(RUTA_RAIZ."/conf.ini");
    }

    public static function utf8EncodeArray($array) {
        $arrayEncode = array();

        foreach($array as $data){
            array_push($arrayEncode, utf8_encode($data));
        }
        return $arrayEncode;
    }

        //USA ESTE METODO SOLO PARA ARCHIVOS DE UN MB O INFERIORES
    public static function getFileBase64($archivo) {
        $archivoBase = new \StdClass();

        $tmpFile = pathinfo($archivo);
        $type = $tmpFile["extension"];
        $data =  base64_encode(file_get_contents($archivo));
        $base64 = 'data:application/' . $type . ';base64,' . $data;

        $archivoBase->extension = $type;
        $archivoBase->file = $base64;
        $archivoBase->name = $tmpFile["filename"];
        $archivoBase->fullName = $tmpFile["filename"] . "." .$type ;
        
        return $archivoBase;
    }
        //USA ESTE METODO SOLO PARA ARCHIVOS DE UN MB O INFERIORES
    public static function createPDFBase64($htmlContent, $nombre,$extension) {
        $dompdf = new Dompdf();
        $dompdf->loadHtml(utf8_decode($htmlContent));
        $dompdf->setPaper('A4'); // (Opcional) Configurar papel y orientación
        $dompdf->render(); // Generar el PDF desde contenido HTML
        $pdf = self::convertFormatBase64($dompdf->output(),$nombre,$extension); // Obtener el PDF generado

        return $pdf;
    }
        //USA ESTE METODO SOLO PARA ARCHIVOS DE UN MB O INFERIORES
    private static function convertFormatBase64($file,  $nombre, $extension) {
        $archivoBase = new \StdClass();

        $data = chunk_split( base64_encode($file) );
        $base64 = 'data:application/' . $extension . ';base64,' . $data;

        $archivoBase->extension = $extension;
        $archivoBase->file = $base64;
        $archivoBase->name = $nombre;
        $archivoBase->fullName = $nombre . "." .$extension ;

        return $archivoBase;
    }
        //CREATE PDF
    public static function createPDF($htmlContent, $nombre, $ruta) {
        $archivoPdf = new \StdClass();

        $dompdf = new Dompdf();
        $dompdf->loadHtml(utf8_decode($htmlContent));
        $dompdf->setPaper('A4'); //(OPCIONAL) CONFIGURAR PAPEL Y ORIENTACIÓN
        $dompdf->render(); //GENERAR EL PDF DESDE CONTENIDO HTML
        $pdf = $dompdf->output(); //OBTENER EL PDF GENERADO
        $rutaPdf =$ruta.'\\'.$nombre.'.pdf';
            //GENERA EL ARCHIVO Y LO COLOCA EN UNA RUTA
        file_put_contents($rutaPdf, $pdf);
        $rutaPublica = str_replace(RUTA_PADRE,"",$rutaPdf);
        $archivoPdf->file = $rutaPublica;
        $archivoPdf->fullName = $nombre.".pdf";
        return $archivoPdf;
    }
        //GENERA UNA PLATILLA BASICA DE EXCEL O CSV, RECIBE UNA MATRIZ, CADA RENGLON DE LA MATRIZ 
        //SE AGREGARA AL OBJETO COMO UNA FILA
    public static function createExcel($nombre,$datos,$extension,$delimitador,$rutaCSV) {
        $archivoCsv= new \StdClass();

        $nombreCompleto = $nombre.".".$extension;
        $excel = new SimpleExcel('csv');

        $excel->writer->setData(
            $datos
        );

        $excel->writer->setDelimiter($delimitador);   
        $excel->writer->saveFile($nombre,$rutaCSV."/".$nombreCompleto); 

        $rutaPublica = str_replace(RUTA_PADRE,"",$rutaCSV);

        $archivoCsv->file = $rutaPublica."/".$nombreCompleto;
        $archivoCsv->fullName = $nombreCompleto;

        return $archivoCsv;
    }

    public static function limpiarCadenaLogin($str){
        $str = trim($str);
        $str = filter_var($str, FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES|FILTER_FLAG_ENCODE_AMP);
        $str = filter_var($str, FILTER_SANITIZE_MAGIC_QUOTES);

        $textoLimpio = preg_replace('([^A-Za-z0-9\.\-\_])', '', $str);	     					
		return $textoLimpio;
    }

    public static function soloNumeros($str){
        $str = trim($str);
        $str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
        return (int) $str;
    }

    public static function formatMoney($money){
        $money = trim($money);
        $money = filter_var($money, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION|FILTER_FLAG_ALLOW_THOUSAND);
        return (float) $money;
    }

    public static function toCleanString($texto) {
        return preg_replace('([^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\@\.\s\-\_])', '', $texto);
    }

    public function validateDate($date, $format = 'Y-m-d') {
        $date = str_replace('/','-',$date);
        return date($format, strtotime($date) );
    }

    public static function validaTel($tel){
        $tel = trim($tel);
        return filter_var($tel, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function formatEmail($correo){
        $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
        return (string) $correo;
    }

    public static function validarCorreo($correo){      
        $res = false;
            //REMOVER CARACTERES NO PERMITIDOS EN EL EMAIL
        $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
            
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) { //VALIDAR CORREO
            $res = true;
        } 
        return $res;
    }
    
    public static function getErrorMessage($message){
        return "Code: ".$message->getCode()." Message: ".utf8_encode($message->getMessage());
    }

    public static function getErrorSP($message){
        return "Code: ".$message[0]." Message: ".utf8_encode( $message[1] );
    }

    public static function search_multiarray($elem, $array) {
        foreach ($array as $key => $value) {
            if ($value == $elem){
                return true;
            } else if (is_array($value)) {
                if (self::search_multiarray($elem, $value)){
                    return true;
                }
            }
        }
        return false;
    }

    public static function validaFields($fields){
        foreach ($fields as $field) {
            if ( !isset($field) ) {
                return true;
            }
        }
    }

    public static function isEmpty($campos){
        $res = true; 
        for ($i = 0; $i < count($campos); $i++){
            $campo = strlen($campos[$i]);
            if ($campo <= 0) {
                $res = false;
                break;
            }
        }   
        return $res;
    }
}