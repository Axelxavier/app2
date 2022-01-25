<?php

namespace App\Exports;

use App\Models\Tco;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Facades\Excel;

class TcoExportNormal implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting, WithProperties, WithEvents, WithPreCalculateFormulas
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $cuentafilas;

    public function __construct(String $nomprov)
    {
        $this->nomprov = $nomprov;
    }

    public function headings(): array
    {
        return [
            ['Liquidación de Servicios Logisticos'],
            ['Del 21 Dic al 31 Dic'],
            ['Proveedor',
            'Division',
            'Departamento',
            'Fecha Proceso',
            'Documento',
            'Marca',
            'Tipo Producto',
            'Tarifa Cross',
            'Tarifa Pick',
            'Tarifa Dev',
            'Unidades Cross',
            'Unidades Pick',
            'Unidades Dev',
            'Costolog Cross S/',
            'Costolog Pick S/',
            'Costolog Dev S/',            
            'Costo Logistico S/']          
        ];
    }

    public function collection()
    {
        $nomprov = $this->nomprov;
        
        $provporcentajes = DB::table('pn_coblog_tco')
                    ->select('Proveedor', 
                            'Division', 
                            'Departamento',
                            'Fecha_Proceso',
                            'Documento', 
                            'Marca',
                            'Tipo_Producto',
                            'tarifa_s_cross',
                            'tarifa_s_pick',
                            'tarifa_s_dev',
                            'unidades_cross',
                            'unidades_pick',
                            'unidades_dev',
                            'costolog_s_cross', 
                            'costolog_s_pick', 
                            'costolog_s_dev',                             
                            'monto_aplicado')                    
                    ->where('descuento_tipo','Cobro 100%')
                    ->where('Tipo_Marca','TERCERAS')
                    ->where('id_descripcion','ProvFac_Dic2021')
                    //->wherein('id_descripcion',['Junio2021_aldeas','Julio2021_aldeas'])
                    ->where('Proveedor','like','%'.$nomprov.'%')                    
                    ->get();
                    
        $this->cuentafilas = count($provporcentajes);

        return $provporcentajes;
    }

    public function styles(Worksheet $sheet)
    {
        $filafin = $this->cuentafilas + 3;
        $celdafinal = $filafin + 1;        
        $sheet->setCellValue("P{$celdafinal}", "TOTAL");
        $sheet->setCellValue("Q{$celdafinal}", "=SUM(Q4:Q{$filafin})");

        return [
            // Style the first row as bold text.
            3    => ['font' => ['bold' => true, 'size' => 12]],            
            'A' => ['font' => ['bold' => true]],
            'A1'    => ['font' => ['bold' => true, 'size' => 16]],
            'A2'    => ['font' => ['bold' => true, 'size' => 12]],

        ];
    }

    public function columnFormats(): array
    {
        return [
            
            
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Harry Carreño',            
            'title'          => 'Liquidación Servicios Logisticos',
        ];
    }

    public function registerEvents(): array
    {
        return [            
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle(
                    'A3:Q3',
                    [
                        'borders' => [
                            'outline' => [      
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,                         
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }
}
