<?php

namespace App\Http\Controllers;

use App\Models\Tco;
use App\Models\Fillrate;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    //funcion cargatco, ojo antes de usarla es necesario convertir
    //el archivo tco a csv, validar que las comas de los nros no se
    //crucen con las del archivo
    public function cargatco(){
        
        //antes es necesario copiar el archivo cargatco en la ruta public
        $path = public_path('cargatco.csv');          
        
        //lines nos devuelve un array por linea del archivo
        $lines = file($path);
        //utf8 para eliminar los errores con la condificación
        //array map aplica la funcion a cada elemento del array
        $utf8_lines = array_map('utf8_encode',$lines);
        //str_getcsv organiza en un array cada elemento
        $array = array_map('str_getcsv',$utf8_lines);       

        //return sizeof($array);
        //return $array;

        //si el archivo está separado por puntos y comas es necesario primero reemplazar las comas x nada y luego reemplazar los puntos y comas por comas

        for ($i=1; $i < sizeof($array); $i++) { 

            $tco = new Tco();
            $tco->proveedor = $array[$i][0];
            $tco->Ruc = $array[$i][1];
            $tco->Division = $array[$i][2];
            $tco->Departamento = $array[$i][3];
            $tco->Fecha_Proceso = $array[$i][4];
            $tco->Documento = $array[$i][5];
            $tco->Marca = $array[$i][6];
            $tco->Tipo_Producto = $array[$i][7];
            $tco->Tipo_Marca = $array[$i][8];
            $tco->sucursal_recp = $array[$i][9];
            $tco->Mh_orig = $array[$i][10];
            $tco->Tarifa_s_cross = $array[$i][11];
            $tco->tarifa_s_pick = $array[$i][12];
            $tco->tarifa_s_dev = $array[$i][13];
            $tco->unidades_cross = $array[$i][14];
            $tco->unidades_pick = $array[$i][15];
            $tco->unidades_dev = $array[$i][16];
            $tco->stock_s_cross = $array[$i][17];
            $tco->stock_s_pick = $array[$i][18];
            $tco->stock_s_dev = $array[$i][19];
            $tco->costolog_s_cross = $array[$i][20];
            $tco->costolog_s_pick = $array[$i][21];
            $tco->costolog_s_dev = $array[$i][22];

            $tco->save();
            
        }
        return('hecho!');
    }

    public function cargafr(){
        
        //antes es necesario copiar el archivo cargatco en la ruta public
        $path = public_path('cargafr.csv');          
        
        //lines nos devuelve un array por linea del archivo
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);        
        //return sizeof($lines);
        //utf8 para eliminar los errores con la condificación
        //array map aplica la funcion a cada elemento del array
        $utf8_lines = array_map('utf8_encode',$lines);
        //return $utf8_lines;
        //str_getcsv organiza en un array cada elemento
        $array = array_map('str_getcsv',$utf8_lines);       
        //return $array;

        //return sizeof($array);

        for ($i=1; $i < sizeof($array); $i++) { 

            $fr = new Fillrate();
            $fr->FLAG_OCABIERTA = $array[$i][0];
            $fr->DPTO = $array[$i][1];
            $fr->CODAREA = $array[$i][2];
            $fr->AREA = $array[$i][3];
            $fr->CODDIVISION = $array[$i][4];
            $fr->DIVISION = $array[$i][5];
            $fr->CODDPTO = $array[$i][6];
            $fr->CODMARCA = $array[$i][7];
            $fr->MARCA = $array[$i][8];
            $fr->CODPROVEEDOR = $array[$i][9];
            $fr->PROVEEDOR = $array[$i][10];
            $fr->CODSUC = $array[$i][11];
            $fr->SUCURSAL = $array[$i][12];
            $fr->NROORDEN = $array[$i][13];
            $fr->TIPOOC = $array[$i][14];
            $fr->COD_SKU = $array[$i][15];
            $fr->SKU = $array[$i][16];
            $fr->ESPREDISTRIBUIDA = $array[$i][17];
            $fr->FECHAEMISION = $array[$i][18];
            $fr->FECHACANCELACION = $array[$i][19];

            $fr->FECHAPROXRECEP = $array[$i][20];
            $fr->FECHAESPERADAEMBARQUE = $array[$i][21];
            $fr->FECHAREALEMBARQUE = $array[$i][22];
            $fr->FECHAREALRECEPCION = $array[$i][23];
            $fr->FECHAULTIMARECEPCION = $array[$i][24];
            $fr->FECHAINGRESO = $array[$i][25];
            $fr->FECHAACTUALIZACION = $array[$i][26];
            $fr->ESTADO = $array[$i][27];
            $fr->TEMPORADA = $array[$i][28];
            $fr->PAIS = $array[$i][29];

            $fr->PROCEDENCIA = $array[$i][30];
            $fr->CONDIFRECCANT = $array[$i][31];
            $fr->CANTIDADTOTALSOLICITADA = $array[$i][32];
            $fr->COSTOSOLICITADO = $array[$i][33];
            $fr->CANTIDADRECEPCIONADA = $array[$i][34];
            $fr->COSTORECEPCION = $array[$i][35];
            $fr->VIGENCIAOC = $array[$i][36];
            $fr->ESTADOVIGENCIAOC = $array[$i][37];
            $fr->ESTADOFILLRATE = $array[$i][38];

            $fr->DIASVENCIM = $array[$i][39];
            $fr->ESTADODIASVENCIM = $array[$i][40];
            $fr->DIFCANREC = $array[$i][41];
            $fr->FILLRATE = $array[$i][42];
            $fr->INDICADOR = $array[$i][43];
            $fr->PREBLA = $array[$i][44];
            $fr->PREBLASIGV = $array[$i][45];
            $fr->DSCTOPROM = $array[$i][46];
            $fr->CONTRUNIPY = $array[$i][47];
            $fr->FILLRATETARGET = $array[$i][48];

            $fr->UND_LUCROCESAN = $array[$i][49];
            $fr->LUCROCESAN = $array[$i][50];
            $fr->FECINI = $array[$i][51];
            $fr->FECFIN = $array[$i][52];
            $fr->IND_OC = $array[$i][53];
            $fr->GMUNIT = $array[$i][54];
            $fr->PREPROMVTA = $array[$i][55];
            $fr->GASADM = $array[$i][56];
            $fr->GMUNITSGA = $array[$i][57];
            $fr->CONTRIUNITDGA = $array[$i][58];

            $fr->DSCTOCOMP = $array[$i][59];
            $fr->LUCESUNI = $array[$i][60];
            $fr->GLOSA = $array[$i][61];
            $fr->GMPROM = $array[$i][62];
            $fr->FECINI2 = $array[$i][63];
            $fr->FECFIN2 = $array[$i][64];
            $fr->excepcion = $array[$i][65];   

            $fr->save();
            
        }
        return('hecho!');
    }
}
