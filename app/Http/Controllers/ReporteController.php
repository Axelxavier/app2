<?php

namespace App\Http\Controllers;

use App\Exports\TcoExport;
use App\Exports\TcoExportNormal;
use App\Exports\FillrateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    //
    public function generareporte(){

         $provporcentajes = DB::table('pn_coblog_tco')
                    ->select('Proveedor')
                    ->distinct()
                    ->where('descuento_tipo','cobro%')
                    ->where('Tipo_Marca','TERCERAS')
                    ->where('id_descripcion','Enero2022')  
                    //->wherein('id_descripcion',['Junio2021_aldeas','Julio2021_aldeas'])
                    // ->where('Proveedor','like','%full bik%')                                    
                    ->get();
       
        foreach ($provporcentajes as $provporcentaje) {
            
            $reporte = new TcoExport($provporcentaje->Proveedor);

            Excel::store($reporte, $provporcentaje->Proveedor.'.xlsx','public');
        }

          return 'Listo reportes %';       
        
    }

    public function generareportenormal(){

       $provcobrototales = DB::table('pn_coblog_tco')
                   ->select('Proveedor')
                   ->distinct()
                   ->where('descuento_tipo','Cobro 100%')
                   ->where('Tipo_Marca','TERCERAS')
                   ->where('id_descripcion','Enero2022')
                   //->wherein('id_descripcion',['Junio2021_aldeas','Julio2021_aldeas'])
                   //->where('Proveedor','like','%day of%')                                    
                   ->get();
       
       foreach ($provcobrototales as $provcobrototal) {
           
           $reporte = new TcoExportNormal($provcobrototal->Proveedor);

           Excel::store($reporte, $provcobrototal->Proveedor.'.xlsx','public');
       }

       return 'Listo reportes normal';       
       
   }

   public function generareportefr(){

    $provfillrate = DB::table('pn_fillrate_comu')
                ->select('CODPROVEEDOR','PROVEEDOR')
                ->distinct() 
                ->where('id_descripcion','Enero2022')                
                ->where('FLAG_OCABIERTA','NO')                
                ->where('ESTADO','Recepcion Completa')             
                //->where('PROVEEDOR','like','%NEWELL%')         
                ->get();
    
    foreach ($provfillrate as $provfr) {
        
        $reporte = new FillrateExport($provfr->CODPROVEEDOR);

        Excel::store($reporte, $provfr->PROVEEDOR.'.xlsx','public');
    }

    return 'Listo';       
    
}
    
}
