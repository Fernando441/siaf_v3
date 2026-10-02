<?php
namespace app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Unidad\Unidad;

class UnidadesContratoExport implements FromCollection, WithHeadings
{
    protected $licitacion;
    use Exportable;
    public function  __construct($licitacion)
    {
        $this->licitacion = $licitacion;
    }


    public function collection()
    {

        $empleados = Unidad::select('unidad.no_serie','unidad.placa','unidad.numero_economico', 'mu.nombre_marca', 'mou.nombre_modelo','unidad.unidad_year', 'stv.tipo_vehiculo', 'unidad.op_engomado', 'unidad.holograma', 'unidad.entidad_placas', 'unidad.importe_iva', 'unidad.fecha_factura', 'unidad.id_aseguradora', 'unidad.no_poliza_seguro', 'unidad.fecha_vencimiento_poliza', 'unidad.no_tarjeta_circulacion', 'unidad.id_tipo_asignacion', 'unidad.proyectos_id')
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("licitacion_proposicion_economica as lpe", "lpe.id", '=', "unidad.licitacion_propuesta_economica_id")
            ->leftjoin("segmentos as seg", "seg.id", '=', "lpe.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as stv", "stv.id", '=', "seg.tipo_vehiculo_id")
            ->where('unidad.licitaciones_id', 26)->get();
            // dd($empleados);

        return $empleados;
    }

    public function headings(): array
    {
        return [
            "No serie",
            "Placa",
            "Economico",
            "Marca",
            "Sub marca",
            "Año modelo",
            "Tipo vehiculo",
            "Color engomado",
            "Tipo holograma",
            "Entidad placas",
            "Costo vehiculo",
            "Fecha compra",
            "Compañia seguro",
            "No poliza",
            "Fecha vencimiento poliza",
            "No. tarjeta circulacion",
            "Estado de asignacion",
            "Proyecto unidad",
        ];
    }


}
