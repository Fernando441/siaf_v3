<?php

namespace App\Http\Controllers\Siniestros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\Folio;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Siniestros\SiniestroTipoDocumento;
use App\Models\Siniestros\SiniestroHdi;
use App\Models\Siniestros\SiniestroHdiEvidencia;
use App\Models\Siniestros\SiniestroHdiHistorial;
use App\Imports\SiniestrosHdiImport;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Illuminate\Support\Facades\File;


class SiniestrosHdiController extends Controller
{
    protected $folio;
    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;

    }

    public function catalogohdi()
    {
        $siniestro_hdi = SiniestroHdi::where('siniestros_agencia_id', 3)->get();

        return view('siniestro.hdi.catalogo-hdi', compact('siniestro_hdi'));
    }

    public function cargamasivhdi(Request $request)
    {
        Excel::import( new SiniestrosHdiImport(), $request->file('file_carga'));

        session()->flash('success', 'Se importó correctamente el archivo.');
        return redirect()->route('siniestro.catalogohdi');
    }

    public function editarsiniestrohdi($id_siniestro)
    {
        $siniestro_hdi = SiniestroHdi::where('id', $id_siniestro)->first(); 

        $documentos = SiniestroTipoDocumento::where('id_status_delete',1)->get();
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $historial_deducibles = SiniestroHdiHistorial::where('siniestro_hdi_id', $id_siniestro)->get();
        $evidencia_siniestro = SiniestroHdiEvidencia::where('siniestro_hdi_id', $id_siniestro)->get();

        return view('siniestro.hdi.editar-registro-hdi', compact('siniestro_hdi', 'id_siniestro', 'cadenaTipoDocumento', 'historial_deducibles','evidencia_siniestro')); 
    }

    public function editsiniestrohdi(Request $request)
    {
        // dd($request);
            $estimacion_reserva_dm = ($request->estimacion_reserva_dm === null || $request->estimacion_reserva_dm === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->estimacion_reserva_dm);
            $estimacion_reserva_rt = ($request->estimacion_reserva_rt === null || $request->estimacion_reserva_rt === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->estimacion_reserva_rt);
            $estimacion_reserva_gm = ($request->estimacion_reserva_gm === null || $request->estimacion_reserva_gm === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->estimacion_reserva_gm);
            $estimacion_reserva_rc = ($request->estimacion_reserva_rc === null || $request->estimacion_reserva_rc === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->estimacion_reserva_rc);
            $reserva_otras_coberturas = ($request->reserva_otras_coberturas === null || $request->reserva_otras_coberturas === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->reserva_otras_coberturas);
            $reserva_vigente = ($request->reserva_vigente === null || $request->reserva_vigente === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->reserva_vigente);
            $reserva_anterior = ($request->reserva_anterior === null || $request->reserva_anterior === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->reserva_anterior);
            $avance = ($request->avance === null || $request->avance === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->avance);
            $ingresos_o_recuperaciones = ($request->ingresos_o_recuperaciones === null || $request->ingresos_o_recuperaciones === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->ingresos_o_recuperaciones);
            $deducible = ($request->deducible === null || $request->deducible === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->deducible);
            $pagos_realizados_por_hdi = ($request->pagos_realizados_por_hdi === null || $request->pagos_realizados_por_hdi === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->pagos_realizados_por_hdi);
            $salvamento = ($request->salvamento === null || $request->salvamento === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->salvamento);
            $total_ocurrido = ($request->total_ocurrido === null || $request->total_ocurrido === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->total_ocurrido);
            $neto_ocurrido = ($request->neto_ocurrido === null || $request->neto_ocurrido === ' -   ')? 0: (float) str_replace(['.', ','], ['', '.'], $request->neto_ocurrido);

        $data = [
            'reporte_cabina' => $request->reporte_cabina,
            'numero_siniestro' => $request->numero_siniestro,
            'fecha_ocurrido' => $request->fecha_ocurrido,
            'year_ocurrido' => $request->year_ocurrido,
            'numero_poliza' => $request->numero_poliza,
            'estatus_poliza' => $request->estatus_poliza,
            'inciso' => $request->inciso,
            'proyecto' => $request->proyecto,
            'inicio_vigencia' => $request->inicio_vigencia,
            'termino_vigencia' => $request->termino_vigencia,
            'estado' => $request->estado,
            'ciudad' => $request->ciudad,
            'conductor' => $request->conductor,
            'telefono' => $request->telefono,
            'vehiculo' => $request->vehiculo,
            'year' => $request->year,
            'serie' => $request->serie,
            'placa' => $request->placa,
            'causa_siniestro' => $request->causa_siniestro,
            'hora_reporte' => $request->hora_reporte,
            'responsable' => $request->responsable,
            'evento_cabina' => $request->evento_cabina,
            'tipo_siniestro' => $request->tipo_siniestro,
            'estatus_siniestro' => $request->estatus_siniestro,
            'con_costo' => $request->con_costo,
            'equipo_pesado' => $request->equipo_pesado,
            'estimacion_reserva_dm' => $estimacion_reserva_dm,
            'estimacion_reserva_rt' => $estimacion_reserva_rt,
            'estimacion_reserva_gm' => $estimacion_reserva_gm,
            'estimacion_reserva_rc' => $estimacion_reserva_rc,
            'reserva_otras' => $reserva_otras_coberturas,
            'reserva_vigente' => $reserva_vigente,
            'reserva_anterior' => $reserva_anterior,
            'avance' => $avance,
            'ingresos_recuperaciones' => $ingresos_o_recuperaciones,
            'deducible' => $deducible,
            'pagos_realizados_dhi' => $pagos_realizados_por_hdi,
            'salvamento' => $salvamento,
            'total_ocurrido' => $total_ocurrido,
            'neto_ocurrido' => $neto_ocurrido,
            'contratante' => $request->contratante,
            'cobertura' => $request->cobertura,
            'legal' => $request->legal,
            'taller' => $request->taller,
            'perdida_total' => $request->perdida_total,
            'robo_localizado' => $request->robo_localizado,
            'pt_indemnizada' => $request->pt_indemnizada,
            'comentarios' => $request->comentarios,
            'primas_no_denegadas' => $request->primas_no_denegadas,
            'iduserUpdated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        SiniestroHdi::where('id', $request->id)->update($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Siniestrohdi/'.$request->id, $archivo, $archivoNombre);
                $data = [
                    'siniestro_hdi_id' => $request->id,
                    'tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                SiniestroHdiEvidencia::insert($data);
            }
        }
        session()->flash('success', 'El siniestro se modifico correctamente');
        return redirect()->route('siniestro.catalogohdi');
    }

    public function deletehdievidencia(Request $request)
    {
        $doc = SiniestroHdiEvidencia::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('Siniestrohdi/'.$doc->id.'/'.$doc->documento);
            SiniestroHdiEvidencia::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);        
    }

    public function versiniestrohdi($id_siniestro)
    {
        $siniestro_hdi = SiniestroHdi::where('id', $id_siniestro)->first(); 
        $evidencia_siniestro = SiniestroHdiEvidencia::where('siniestro_hdi_id', $id_siniestro)->get();
        $historial_deducibles = SiniestroHdiHistorial::where('siniestro_hdi_id', $id_siniestro)->get();

        return view('siniestro.hdi.ver-registro-hdi', compact('siniestro_hdi', 'id_siniestro','evidencia_siniestro', 'historial_deducibles')); 
    }

    public function crearsiniestrohdi()
    {
        $documentos = SiniestroTipoDocumento::where('id_status_delete',1)->get();
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->nombre_documento.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';


        return view('siniestro.hdi.crear-registro-hdi', compact('cadenaTipoDocumento'));        
    }

    public function createhdievidencia(Request $request)
    {
        $data = [
            'no_folio' => $this->folio->getFolioSiniestroHdi(),
            'siniestros_agencia_id' => 3,
            'reporte_cabina' => $request->reporte_cabina,
            'numero_siniestro' => $request->numero_siniestro,
            'fecha_ocurrido' => $request->fecha_ocurrido,
            'year_ocurrido' => $request->year_ocurrido,
            'numero_poliza' => $request->numero_poliza,
            'estatus_poliza' => $request->estatus_poliza,
            'inciso' => $request->inciso,
            'proyecto' => $request->proyecto,
            'inicio_vigencia' => $request->inicio_vigencia,
            'termino_vigencia' => $request->termino_vigencia,
            'estado' => $request->estado,
            'ciudad' => $request->ciudad,
            'conductor' => $request->conductor,
            'telefono' => $request->telefono,
            'vehiculo' => $request->vehiculo,
            'year' => $request->year,
            'serie' => $request->serie,
            'placa' => $request->placa,
            'causa_siniestro' => $request->causa_siniestro,
            'hora_reporte' => $request->hora_reporte,
            'responsable' => $request->responsable,
            'evento_cabina' => $request->evento_cabina,
            'tipo_siniestro' => $request->tipo_siniestro,
            'estatus_siniestro' => $request->estatus_siniestro,
            'con_costo' => $request->con_costo,
            'equipo_pesado' => $request->equipo_pesado,
            'estimacion_reserva_dm' => $request->estimacion_reserva_dm,
            'estimacion_reserva_rt' => $request->estimacion_reserva_rt,
            'estimacion_reserva_gm' => $request->estimacion_reserva_gm,
            'estimacion_reserva_rc' => $request->estimacion_reserva_rc,
            'reserva_otras' => $request->reserva_otras,
            'reserva_vigente' => $request->reserva_vigente,
            'reserva_anterior' => $request->reserva_anterior,
            'avance' => $request->avance,
            'ingresos_recuperaciones' => $request->ingresos_recuperaciones,
            'deducible' => $request->deducible,
            'pagos_realizados_dhi' => $request->pagos_realizados_dhi,
            'salvamento' => $request->salvamento,
            'total_ocurrido' => $request->total_ocurrido,
            'neto_ocurrido' => $request->neto_ocurrido,
            'contratante' => $request->contratante,
            'cobertura' => $request->cobertura,
            'legal' => $request->legal,
            'taller' => $request->taller,
            'perdida_total' => $request->perdida_total,
            'robo_localizado' => $request->robo_localizado,
            'pt_indemnizada' => $request->pt_indemnizada,
            'comentarios' => $request->comentarios,
            'primas_no_denegadas' => $request->primas_no_denegadas,
            'op_deducible' => 0,
            'created_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        $id_siniestro = SiniestroHdi::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('Siniestrohdi/'.$id_siniestro, $archivo, $archivoNombre);
                $data = [
                    'siniestro_hdi_id' => $id_siniestro,
                    'tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                SiniestroHdiEvidencia::insert($data);
            }
        }

        session()->flash('success', 'El siniestro se creo correctamente');
        return redirect()->route('siniestro.catalogohdi');
    }
}
