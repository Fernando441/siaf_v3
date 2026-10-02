<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use App\Models\Unidad\UnidadDocumento;
use App\Models\Unidad\UnidadTipoDocumento;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\ComplementoUnidad;
use App\Models\Unidad\UbicacionUnidad;
use App\Models\Unidad\MarcaUnidad;
use App\Models\Unidad\ModeloUnidad;
use App\Models\Unidad\UnidadTipoVehiculo;
use App\Models\Unidad\AseguradoraUnidad;
use App\Models\Unidad\StatusUnidad;
use App\Models\Unidad\FotoUnidad;
use App\Models\Unidad\UnidadFotografia;
use App\Models\Cliente\Cliente;
use App\Models\Proyecto\Proyecto;
use App\Models\Unidad\TipoAsignacion;
use App\Models\Unidad\UnidadMovimientos;
use App\Models\Unidad\InformacionSeguroUnidad;
use App\Models\Unidad\TipoCobertura;
use App\Models\Unidad\InformacionGpsUnidad;
use App\Models\Unidad\UnidadEquipamiento;

use App\Models\Cliente\Estado;
use App\Models\Taller\TallerSolicitud;
use App\Models\Taller\TallerTipoSolicitud;

use App\Models\Unidad\TramiteEmplacamientoRequisito;
use App\Models\Unidad\TramiteEmplacamientoEvidencia;
use App\Models\Unidad\TramiteVerificacionRequisito;
use App\Models\Unidad\TramiteVerificacionEvidencia;
use App\Models\Unidad\TramiteTenenciaRequisito;
use App\Models\Unidad\TramiteTenenciaEvidencia;
use App\Models\Unidad\TramiteReemplacamientoRequisito;
use App\Models\Unidad\TramiteReemplacamientoEvidencia;
use App\Models\Unidad\TramiteCambioPropietarioRequisito;
use App\Models\Unidad\TramiteCambioPropietarioEvidencia;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroRequisito;
use App\Models\Unidad\TramiteBajaVehiculoSiniestroEvidencia;
use App\Models\Unidad\TramiteBajaVehiculoRoboRequisito;
use App\Models\Unidad\TramiteBajaVehiculoRoboEvidencia;
use App\Models\Unidad\TramiteBajaVehiculoRequisito;  //venta
use App\Models\Unidad\TramiteBajaVehiculoEvidencia;
use App\Models\Unidad\TramiteAseguramientoRequisito;
use App\Models\Unidad\TramiteAseguramientoEvidencia;
use App\Models\Unidad\AsignacionRegistroUnidad;
use App\Models\Unidad\TramiteGpsRequisito;


use App\Models\Unidad\TramiteEmplacamientoInfo;
use App\Models\Unidad\TramiteTenenciaInfo;
use App\Models\Unidad\TramiteVerificacionInfo;

use App\Imports\UnidadesImport;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use App\Models\Unidad\UnidadVenta;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FichaTecnicaUnidadesController extends Controller
{

    protected $folio;
    protected $money_format;
    public function __construct(Folio $folio, Money $money_format)
    {
        $this->middleware('auth');
        $this->folio = $folio;
        $this->money_format = $money_format;
    }


    public function listadofichatecnica()
    {
        $unidades = Unidad::select(
            'unidad.id',
            'unidad.folio',
            'unidad.id_ubicacion',
            'unidad.fecha',
            'unidad.id_marca',
            'unidad.id_modelo',
            'unidad.unidad_year',
            'unidad.no_serie',
            'unidad.placa',
            'unidad.transmision',
            'unidad.no_tarjeta_circulacion',
            'unidad.no_poliza_seguro',
            'unidad.fecha_vencimiento_poliza',
            'unidad.numero_inventario',
            'unidad.color',
            'unidad.id_status',
            'unidad.unidad_asignacion_id',
            'mu.nombre_marca',
            'mou.nombre_modelo',
            'uu.ubicacion',
            'st.nombre_status',
            'pr.id_contrato',
            'uv.id as id_unidad_venta',
            'uv.politicas as politicas',
            'uv.vendido',
            'unidad.numero_economico',
            'unidad.clave_vehicular',
            'unidad.no_tarjeta_circulacion'
        )
            ->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca")
            ->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo")
            ->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion")
            ->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status")
            ->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id")
            ->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id")
            ->where("unidad.id_status_delete", 1)
            ->get();
        // dd($unidades);

		return view('unidades.fichatecnica.listado-unidades-ficha', compact('unidades'));

    }

    public function fichatecnicaunidad($id_unidad)
    {
        $fotografias = UnidadFotografia::where('unidad_id', $id_unidad)->get();
        $unidad_info = Unidad::find($id_unidad);
        $marcas = MarcaUnidad::where('id_status_delete', 1)->get();
        $modelos = ModeloUnidad::where('id_status_delete', 1)->get();
        $active = UnidadFotografia::where('unidad_id', $id_unidad)->first();
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();

        if ($active == null) {
            $ver = 0;
        } else {
            $ver = $active->id;
        }

        $emplcamiento = TramiteEmplacamientoInfo::where('unidad_id', $id_unidad)->get();
        $tenencia = TramiteTenenciaInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();
        $verificacion = TramiteVerificacionInfo::where('unidad_id', $id_unidad)->orderBy('id', 'DESC')->get();

        $mantenimientos = TallerSolicitud::select('taller_solicitud.*', 'taller_tipo_solicitud.tipo', 'taller_solicitud_estado.estado')
            ->join('taller_tipo_solicitud', 'taller_solicitud.taller_tipo_solicitud_id', '=', 'taller_tipo_solicitud.id')
            ->join('taller_solicitud_estado', 'taller_solicitud.taller_solicitud_estado_id', '=', 'taller_solicitud_estado.id')
            ->join('unidad', 'taller_solicitud.unidad_id', '=', 'unidad.id')
            ->where('unidad.id', $id_unidad)
            // ->join('client', 'proyectos.id_cliente', '=', 'client.id_cliente')
            ->get();
            // dd($mantenimientos);


        return view('unidades.fichatecnica.ficha-tecnica', compact('fotografias', 'unidad_info', 'marcas', 'modelos', 'active', 'ver', 'estados', 'emplcamiento', 'tenencia', 'verificacion','id_unidad', 'mantenimientos'));

    }


}