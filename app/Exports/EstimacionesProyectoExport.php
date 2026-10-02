<?php
namespace App\Exports;

use App\Models\Proyecto\EstimacionesProyecto;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EstimacionesProyectoExport implements FromArray, ShouldAutoSize
{
    use Exportable;

    protected $estimacion;

    public function __construct($estimacion)
    {
        $this->estimacion = $estimacion;
    }

    public function array(): array
    {
        $rows = [];

        $estimacion = EstimacionesProyecto::where('id', $this->estimacion)->first();
        $unidades = $estimacion->estimacionesUnidades;

        // Filas de encabezado informativo
        $rows[] = ['Folio:', $estimacion->no_folio];
        $rows[] = ['No. Contrato:', $estimacion->proyecto->no_contrato];
        $rows[] = ['Periodo:', \Carbon\Carbon::parse($estimacion->periodo_inicial)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($estimacion->periodo_final)->format('d/m/Y')];
        $rows[] = ['Cliente:', $estimacion->cliente->razon_social];
        $rows[] = ['RFC:', $estimacion->cliente->rfc];
        $rows[] = [];

        // Cabecera de columnas
        $rows[] = [
            'No.',
            'Segmento',
            'Número Económico',
            'Marca',
            'Modelo',
            'Año Modelo',
            'No. Serie',
            'Placas',
            'Localidad',
            'Días Trabajados',
            'Costo Por Día',
            'Total Mensual',
        ];

        $numero = 1;
        $subtotal = 0;

        foreach ($unidades as $unid) {
            $total_mensual = $unid->precio_segmento * $unid->dias_trabajo;
            $subtotal += $total_mensual;

            $rows[] = [
                $numero++,
                $unid->segmento->segmentoTipoVehiculo->tipo_vehiculo . ' ' .
                $unid->segmento->segmentoMotor->motor . ' ' .
                $unid->segmento->segmentoTransmision->transmision,
                $unid->unidad->numero_economico,
                $unid->unidad->marcaUnidad->nombre_marca,
                $unid->unidad->modeloUnidad->nombre_modelo,
                $unid->unidad->unidad_year,
                $unid->unidad->no_serie,
                $unid->unidad->placa,
                DB::table('unidad_tramite_emplacamiento_info as te')
                    ->join('estado as es', 'es.id_estado', 'te.entidad_placas')
                    ->where('te.unidad_id', $unid->unidad_id)
                    ->orderByDesc('te.id')
                    ->value('es.estado_nombre') ?? '',
                $unid->dias_trabajo,
                number_format($unid->dias_trabajo > 0 ? $total_mensual / $unid->dias_trabajo : 0, 2, '.', ','),
                number_format($total_mensual, 2, '.', ','),
            ];
        }

        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;

        $rows[] = ['', '', '', '', '', '', '', '', '', '', 'Subtotal:', number_format($subtotal, 2, '.', ',')];
        $rows[] = ['', '', '', '', '', '', '', '', '', '', 'IVA (16%):', number_format($iva, 2, '.', ',')];
        $rows[] = ['', '', '', '', '', '', '', '', '', '', 'TOTAL:', number_format($total, 2, '.', ',')];

        return $rows;
    }
}
