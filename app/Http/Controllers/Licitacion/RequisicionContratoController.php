<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Money;
use App\Services\Folio;
use Illuminate\Support\Facades\Auth;
use App\Models\Requisicion\AreaPersonal;
use App\Models\Requisicion\Requisicion;
use App\Models\Requisicion\RequisicionEstatus;
use App\Models\Requisicion\RequisicionPartida;
use App\Models\Requisicion\RequisicionPartidaEstatus;
use App\Models\Licitacion\RequisicionGrupo;
use App\Models\Licitacion\RequisicionSubgrupo;
use App\Models\Licitacion\RequisicionPartidaEquipamiento;
use App\Models\Licitacion\RequisicionTipoTransporte;
use App\Models\Licitacion\RequisicionCobertura;
use App\Models\Licitacion\RequisicionPartidaAseguramiento;
use App\Models\Licitacion\RequisicionEntidadFederativa;
use App\Models\Licitacion\RequisicionTipoPlacas;
use App\Models\Licitacion\RequisicionPartidaEmplacamiento;
use App\Models\Licitacion\RequisicionCombustible;
use App\Models\Licitacion\RequisicionPartidaLugarEntrega;
use App\Models\Licitacion\Licitacion;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\Licitacion\LicitacionSegmento;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;

use App\Models\Segmento\TipoVehiculo;
use App\Models\Segmento\Segmento;
use LDAP\Result;

class RequisicionContratoController extends Controller
{
    protected $folio;

    public function __construct(Folio $folio)
    {
        $this->middleware('auth');
        $this->folio = $folio;
    }

    public function nuevaRequisicion()
    {

        $solicitante = User::select('users.id', 'users.name', 'users.email', 'users.role', 'rl.name as namerole')
            ->leftjoin("roles as rl", "rl.id", "users.role")
            ->where("rl.name", "Supervisor de proyecto")
            ->orWhere("rl.name", "Administrador")
            ->where("users.id_status_delete", 1)
            ->get();


        $licitaciones = Licitacion::where('id_status_delete', 1)->whereNotNull('acto_fallo')->get();
        $licitacionesArray = array();
        foreach ($licitaciones as $licitacion) {
            $licitacionProposicionEconomica = ProposicionEconomica::where('licitacion_id', $licitacion->id)->get();
            if (count($licitacionProposicionEconomica) > 0) {
                $licitacionesArray[] = $licitacion;
            }
        }

        $area_personal = AreaPersonal::where('id_status_delete', 1)->get();
        // dd($licitacionesArray);

        return view('licitaciones.crear-requisicion-concurso', compact('solicitante', 'area_personal', 'licitacionesArray'));
    }

    public function catalogoRequisicion()
    {
        return view('licitaciones.catalogo-requisicion-concurso');
    }

    public function verRequisicion($id)
    {
        $requisicion = Requisicion::find($id);
        $partidas = RequisicionPartida::where('requisicion_id', $id)->where('id_status_delete', 1)->get();

        $segmento = Segmento::where('id_status_delete', 1)->get();
        //Avance financiero en formato json
        $cadenatipovehiculo = "";
        foreach ($segmento as $av) {

            $cadenatipovehiculo .= '"' . $av->id . '":"' . $av->segmentoTipoVehiculo->tipo_vehiculo . ", " . $av->segmentoNoCilindro->no_cilindro . " cilindros, " .  $av->segmentoTransmision->transmision . ", " . $av->segmentoMotor->motor  . '",';
        }
        $cadenatipovehiculo = '{' . rtrim($cadenatipovehiculo, ',') . '}';

        return view('licitaciones.ver-requisicion-concurso', compact('requisicion', 'partidas', 'cadenatipovehiculo'));
    }

    public function editarRequisicion($id)
    {
        $requisicion = Requisicion::find($id);

        $partidas = RequisicionPartida::where('requisicion_id', $id)->where('id_status_delete', 1)->get();


        $solicitante = User::select('users.id', 'users.name', 'users.email', 'users.role', 'rl.name as namerole')
            ->leftjoin("roles as rl", "rl.id", "users.role")
            ->where("rl.name", "Supervisor de proyecto")
            ->where("users.id_status_delete", 1)
            ->get();

        $area_personal = AreaPersonal::where('id_status_delete', 1)->get();

        $segmento = Segmento::where('id_status_delete', 1)->get();
        //Avance financiero en formato json    
        $cadenatipovehiculo = "";
        foreach ($segmento as $av) {

            $cadenatipovehiculo .= '"' . $av->id . '":"' . $av->segmentoTipoVehiculo->tipo_vehiculo . ", " . $av->segmentoNoCilindro->no_cilindro . " cilindros, " .  $av->segmentoTransmision->transmision . ", " . $av->segmentoMotor->motor  . '",';
        }
        $cadenatipovehiculo = '{' . rtrim($cadenatipovehiculo, ',') . '}';

        return view('licitaciones.editar-requisicion-concurso', compact('requisicion', 'partidas', 'solicitante', 'area_personal', 'cadenatipovehiculo'));
    }

    public function guardarRequisicion(Request $request)
    {

        $licitaciones = Licitacion::where('id', $request->licitacion)->first();

        $requisicion = new Requisicion();
        $requisicion->licitaciones_id = $request->licitacion;
        $requisicion->solicitante = $request->solicitante;
        $requisicion->folio = $this->folio->getFolioRequisicion();
        $requisicion->id_area = $request->area;
        $requisicion->fecha_solicitud = $request->fecha_solicitud;
        $requisicion->requisicion_estatus_id = 1; // 1 = Capturada
        $requisicion->id_status_delete = 1;
        $requisicion->iduservistobueno = Auth::user()->id;
        $requisicion->iduserCreated = Auth::user()->id;
        $requisicion->iduserUpdated = Auth::user()->id;
        $requisicion->save();

        $requisicion_id = $requisicion->id;

        $proposicionEconomica = ProposicionEconomica::where('licitacion_id', $request->licitacion)->get();
        $licitacion_segmento = LicitacionSegmento::where('licitacion_id', $request->licitacion)->first();

        if ($licitacion_segmento->observaciones != null) {
            $observaciones = $licitacion_segmento->observaciones;
        } else {
            $observaciones = "";
        }

        foreach ($proposicionEconomica as $proposicion) {
            $requisicionPartida = new RequisicionPartida();
            $requisicionPartida->requisicion_id = $requisicion_id;
            $requisicionPartida->requisicion_partida_estatus_id = 1; // 1 = Capturada
            $requisicionPartida->segmentos_id = $proposicion->segmento_id;
            $requisicionPartida->cantidad = $proposicion->cantidad;
            $requisicionPartida->precio_unitario = $proposicion->precio_unitario;
            $requisicionPartida->cantidad_orden = $proposicion->cantidad;
            $requisicionPartida->observaciones = $observaciones;
            $requisicionPartida->id_status_delete = 1;
            $requisicionPartida->orden_estatus = 0;
            $requisicionPartida->op_cantidades = $licitaciones->tipo_contrato;
            $requisicionPartida->cantidad_maxima = $proposicion->cantidad_maxima;
            $requisicionPartida->iduserCreated = Auth::user()->id;
            $requisicionPartida->iduserUpdated = Auth::user()->id;
            $requisicionPartida->save();
        }

        return redirect()->route('concurso.requisiciones.catalogorequisicion')->with('success', 'Requisición creada correctamente');
    }

    public function eliminarRequisicion(Request $request)
    {

        $requisicion = Requisicion::find($request->id);
        $requisicion->id_status_delete = 2;
        $requisicion->motivo_desactivar = $request->motivo;
        $requisicion->iduserUpdated = Auth::user()->id;
        $requisicion->save();

        session()->flash('success', 'La requisición se desactivo correctamente');
        return redirect()->route('concurso.requisiciones.catalogorequisicion');
    }

    public function requisicionDatatable(Request $request)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Obten todos los registros de la tabla donde licitaciones_id no sea nulo

        $totalRecords = Requisicion::select('count(*) as allcount')->whereNotNull('licitaciones_id')->where('id_status_delete', 1)->count();
        $totalRecordswithFilter = Requisicion::select('count(*) as allcount')->whereNotNull('licitaciones_id')->where('id', 'like', '%' . $searchValue . '%')->where('id_status_delete', 1)->count();

        /* Getting the first element of the array. */
        $order_arr = $columnIndex_arr[0];

        /* Getting the column index of the column that is being sorted. */
        $order_column_index = $order_arr['column'];

        /* Getting the direction of the sort. */
        $order_dir = $order_arr['dir'];

        /* Getting the column name from the array of columns. */
        $order_column_name = $columnName_arr[$order_column_index]['data'];
        $order_column_dir = $order_dir;

        $order_column_dir = $order_column_dir == 'asc' ? 'asc' : 'desc';


        $records = Requisicion::select('*')
            ->whereNotNull('licitaciones_id')
            ->where('id', 'like', '%' . $searchValue . '%')
            ->where('id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();

        foreach ($columnName_arr as $indice => $columna) {

            if ($columna['data'] == 'folio') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = Requisicion::select('*')
                        ->whereNotNull('licitaciones_id')
                        ->where('folio', 'like', '%' . $valor . '%')
                        ->where('id_status_delete', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }

            if ($columna['data'] == 'solicitante') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = Requisicion::select('*')
                        ->whereNotNull('licitaciones_id')
                        ->where('id', 'like', '%' . $searchValue . '%')
                        ->where('solicitante', 'like', '%' . $valor . '%')
                        ->where('id_status_delete', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }

            if ($columna['data'] == 'area') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = Requisicion::select('*')
                        ->whereNotNull('licitaciones_id')
                        ->where('id', 'like', '%' . $searchValue . '%')
                        ->where('area', 'like', '%' . $valor . '%')
                        ->where('id_status_delete', 1)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)->take($rowperpage)->get();
                }
            }
        }

        $data_arr = array();
        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "folio" => $record->folio,
                "solicitante" => $record->usersolicitante->name,
                "area" => $record->areaPersonal->nombre_area,
                "estatus" => $record->requisicionEstatus->estatus,
                "fecha_solicitud" => $record->fecha_solicitud,
                "op_estatus" => $record->requisicion_estatus_id,
                "permisos" => $permiso_array,
                'acciones' => null
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }


    public function eliminarPartida(Request $request)
    {
        $idPartida = $request->id;
        $partida = RequisicionPartida::find($idPartida);
        $partida->id_status_delete = 2;
        $partida->iduserUpdated = Auth::user()->id;
        $partida->save();

        $estatus = true;

        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    // editarPartida
    public function editarPartida(Request $request)
    {
        $idRequisicion = $request->idRequisicion;
        
        $data = [
            'solicitante' => $request->solicitante ? $request->solicitante : null,
            'id_area' => $request->area ? $request->area : null,
            'fecha_solicitud' => $request->fecha_solicitud ? $request->fecha_solicitud : null,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        Requisicion::where('id', $request->idRequisicion)->update($data);

        if ($request->descripcion) {
            $descripciones = $request->descripcion;
            $cantidades = $request->cantidad;
            $observaciones = $request->observaciones;
            foreach ($descripciones as $indice => $descripcion) {
                $partida = new RequisicionPartida();
                $partida->requisicion_id = $idRequisicion;
                $partida->segmentos_id = $descripcion;
                $partida->cantidad = $cantidades[$indice];
                $partida->cantidad_orden = $cantidades[$indice];
                $partida->observaciones = $observaciones[$indice];
                $partida->requisicion_partida_estatus_id = 1;
                $partida->id_status_delete = 1;
                $partida->orden_estatus = 0;
                $partida->iduserCreated = Auth::user()->id;
                $partida->iduserUpdated = Auth::user()->id;
                $partida->save();
            }
        }

        
        return redirect()->route('concurso.requisiciones.editarrequisicion', $idRequisicion)->with('success', 'La requisición se actualizo correctamente');
    }

    public function catalogoRequisicioninactivas()
    {
        $requisiones = Requisicion::where('id_status_delete', 2)->whereNotNull('licitaciones_id')->get();

        return view('licitaciones.catalogo-requisicion-concurso-inactivas', compact('requisiones'));
    }

    public function activarrequisicion(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Requisicion::where('id', $request->id)->update($data);

        session()->flash('success', 'La requsisición se activo correctamente');
        return redirect()->route('concurso.requisiciones.catalogorequisicioninactivas');
    }

    public function finanzasRequisicion(Request $request)
    {
        $requisicion = Requisicion::find($request->id);
        $requisicion->requisicion_estatus_id = 2;
        $requisicion->iduserUpdated = Auth::user()->id;
        $requisicion->save();

        return response()->json(['success' => 'Requisición enviada correctamente']);
    }

    // Agregar Informacion Inicio
    public function addinfopartidas($id)
    {
        $requisicion = Requisicion::find($id);
        $partidas = RequisicionPartida::where('requisicion_id', $id)->where('id_status_delete', 1)->get();
        $segmento = Segmento::where('id_status_delete', 1)->get();
        $cadenatipovehiculo = "";
        foreach ($segmento as $av) {
            $cadenatipovehiculo .= '"' . $av->id . '":"' . $av->segmentoTipoVehiculo->tipo_vehiculo . ", " . $av->segmentoNoCilindro->no_cilindro . " cilindros, " .  $av->segmentoTransmision->transmision . ", " . $av->segmentoMotor->motor  . '",';
        }
        $cadenatipovehiculo = '{' . rtrim($cadenatipovehiculo, ',') . '}';

        return view('licitaciones.requisicion.agregar-informacion-partidas-concurso', compact('requisicion', 'partidas', 'cadenatipovehiculo', 'id'));
    }


    //Agregar información partida
    public function infopartida($partida, $requisicion)
    {

        $info_partida = RequisicionPartida::where('id', $partida)->where('id_status_delete', 1)->first();
        $equipamientos = RequisicionPartidaEquipamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $aseguramientos = RequisicionPartidaAseguramiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $emplacamientos = RequisicionPartidaEmplacamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $lugares_entrega = RequisicionPartidaLugarEntrega::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();


        //Tipos de transporte
        $cadena_tipo_transporte = "";
        $tipo_transporte = RequisicionTipoTransporte::where('id_status_delete', 1)->get();
        foreach ($tipo_transporte as $tipo) {
            $cadena_tipo_transporte .= '"' . $tipo->id . '":"' . $tipo->descripcion . '",';
        }
        $cadena_tipo_transporte = '{' . rtrim($cadena_tipo_transporte, ',') . '}';

        //Equipamento Grupo
        $cadena_grupo = "";
        $equipamento_grupos = RequisicionGrupo::where('id_status_delete', 1)->get();
        foreach ($equipamento_grupos as $grupo) {
            $cadena_grupo .= '"' . $grupo->id . '":"' . $grupo->descripcion . '",';
        }
        $cadena_grupo = '{' . rtrim($cadena_grupo, ',') . '}';

        // Entidad Federativa
        $cadena_entidad_federativa = "";
        $entidad_federativa = RequisicionEntidadFederativa::where('id_status_delete', 1)->get();
        foreach ($entidad_federativa as $entidad) {
            $cadena_entidad_federativa .= '"' . $entidad->id . '":"' . $entidad->descripcion . '",';
        }
        $cadena_entidad_federativa = '{' . rtrim($cadena_entidad_federativa, ',') . '}';

        // Tipo de Placas
        $cadena_tipo_placas = "";
        $tipo_placas = RequisicionTipoPlacas::where('id_status_delete', 1)->get();
        foreach ($tipo_placas as $tipo) {
            $cadena_tipo_placas .= '"' . $tipo->id . '":"' . $tipo->descripcion . '",';
        }
        $cadena_tipo_placas = '{' . rtrim($cadena_tipo_placas, ',') . '}';

        // Combustible
        $cadena_combustible = "";
        $combustible = RequisicionCombustible::where('id_status_delete', 1)->get();
        foreach ($combustible as $comb) {
            $cadena_combustible .= '"' . $comb->id . '":"' . $comb->descripcion . '",';
        }
        $cadena_combustible = '{' . rtrim($cadena_combustible, ',') . '}';

        return view('licitaciones.requisicion.agregar-informacion-partida-ind-concurso', compact('requisicion', 'partida', 'info_partida', 'equipamento_grupos', 'cadena_grupo', 'equipamientos', 'cadena_tipo_transporte', 'aseguramientos', 'cadena_entidad_federativa', 'cadena_tipo_placas', 'cadena_combustible', 'emplacamientos', 'lugares_entrega'));
    }

    public function verPartida($partida, $requisicion){

        $info_partida = RequisicionPartida::where('id', $partida)->where('id_status_delete', 1)->first();
        $equipamientos = RequisicionPartidaEquipamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $aseguramientos = RequisicionPartidaAseguramiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $emplacamientos = RequisicionPartidaEmplacamiento::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();
        $lugares_entrega = RequisicionPartidaLugarEntrega::where('id_status_delete', 1)->where('requisicion_partida_id', $partida)->get();

        return view('licitaciones.requisicion.ver-partida-concurso', compact('requisicion', 'partida', 'info_partida', 'equipamientos', 'aseguramientos', 'emplacamientos', 'lugares_entrega'));

    }

    // Obtener subgrupos
    public function obtenersubgrupos(Request $request)
    {
        $subgrupos = RequisicionSubgrupo::where('id_status_delete', 1)->where('requisicion_grupo_id', $request->id)->get();
        $cadena_subgrupo = "";
        foreach ($subgrupos as $subgrupo) {
            $cadena_subgrupo .= '"' . $subgrupo->id . '":"' . $subgrupo->descripcion . '",';
        }
        $cadena_subgrupo = '{' . rtrim($cadena_subgrupo, ',') . '}';
        return response()->json(['success' => $cadena_subgrupo]);
    }

    // Guardar información de partida
    public function guardarinfopartida(Request $request)
    {
        $info_licitacion = Requisicion::where('id', $request->requisicion_id)->first();
        $info_folio= Licitacion::where('id', $info_licitacion->licitaciones_id)->first();

        //Equipamiento
        if ($request->cantidad) {
            $inputs_cantidades = $request->cantidad;
            $select_subgrupo = $request->select_grupo;
            $observaciones = $request->observaciones;
        
            if($request->hasfile('select_subgrupo')){
                $archivos = $request->file('select_subgrupo');
                foreach($archivos as $indice => $archivo)
                {
                    $archivoNombre = $archivo->hashName();
                    $mimeType = $archivo->getMimeType();
                    Storage::putFileAs('licitacion/' . $info_folio->folio, $archivo, $archivoNombre);

                    $equipamiento = new RequisicionPartidaEquipamiento();
                    $equipamiento->requisicion_partida_id = $request->partida_id;
                    $equipamiento->cantidad = $request->cantidad[$indice];
                    $equipamiento->archivo_equipamiento = $archivoNombre;
                    $equipamiento->requisicion_grupo_id = $select_subgrupo[$indice];
                    $equipamiento->observaciones = $observaciones[$indice];
                    $equipamiento->op_documento = 1;
                    $equipamiento->id_status_delete = 1;
                    $equipamiento->iduserCreated = auth()->user()->id;
                    $equipamiento->iduserUpdated = auth()->user()->id;
                    $equipamiento->save();
                }
            }
        }

        //Aseguramiento
        if ($request->cantidad_aseguramiento) {

            $inputs_cantidades_aseguramiento = $request->cantidad_aseguramiento;
            $select_cobertura = $request->select_cobertura;
            $vigencia = $request->vigencia;
            $observaciones_aseguramiento = $request->observaciones_aseguramiento;

            if($request->hasfile('select_cobertura')){
                $archivos = $request->file('select_cobertura');
                foreach($archivos as $indice => $archivo)
                {
                   
                    $archivoNombre = $archivo->hashName();
                    $mimeType = $archivo->getMimeType();
                    Storage::putFileAs('licitacion/' . $info_folio->folio, $archivo, $archivoNombre);


                    $aseguramiento = new RequisicionPartidaAseguramiento();
                    $aseguramiento->requisicion_partida_id = $request->partida_id;
                    $aseguramiento->requisicion_tipo_transporte_id = $request->select_tipo_transporte[$indice];
                    $aseguramiento->id_status_delete = 1;
                    $aseguramiento->cantidad = $request->cantidad_aseguramiento[$indice];
                    $aseguramiento->vigencia = $vigencia[$indice];
                    $aseguramiento->vigencia_fin = $request->vigenciafin[$indice];
                    $aseguramiento->observaciones = $observaciones_aseguramiento[$indice];
                    $aseguramiento->doc_aseguramiento = $archivoNombre;
                    $aseguramiento->op_documento_aseg = 1;
                    $aseguramiento->id_status_delete = 1;
                    $aseguramiento->iduserCreated = auth()->user()->id;
                    $aseguramiento->iduserUpdated = auth()->user()->id;
                    $aseguramiento->save();
                }
            }
        }

        //Emplacamiento
        if ($request->cantidad_emplacamiento) {

            $inputs_cantidades_emplacamiento = $request->cantidad_emplacamiento;
            $select_tipo_placas = $request->select_tipo_placas;
            $select_entidad_federativa = $request->select_entidad_federativa;

            foreach ($inputs_cantidades_emplacamiento as $indice => $cantidad_emplacamiento) {
                $emplacamiento = new RequisicionPartidaEmplacamiento();

                $emplacamiento->requisicion_partida_id = $request->partida_id;
                $emplacamiento->requisicion_tipo_placas_id = $select_tipo_placas[$indice];
                $emplacamiento->requisicion_entidad_federativa_id = $select_entidad_federativa[$indice];
                $emplacamiento->cantidad = $cantidad_emplacamiento;
                $emplacamiento->id_status_delete = 1;
                $emplacamiento->iduserCreated = auth()->user()->id;
                $emplacamiento->iduserUpdated = auth()->user()->id;
                $emplacamiento->save();
            }
        }

        //Lugar de entrega
        if ($request->cantidad_entrega){
                    
                $inputs_cantidades_entrega = $request->cantidad_entrega;
                $fecha_entrega = $request->fecha_entrega;
                $entrega_entidad_federativa = $request->entrega_entidad_federativa;
                $entrega_municipio = $request->entrega_municipio;
                $entrega_localidad = $request->entrega_localidad;
                $select_combustible = $request->select_combustible;
                $entrega_observaciones = $request->entrega_observaciones;

                foreach ($inputs_cantidades_entrega as $indice => $cantidad_entrega) {
                    $lugar_entrega = new RequisicionPartidaLugarEntrega();

                    $lugar_entrega->requisicion_partida_id = $request->partida_id;
                    $lugar_entrega->cantidad = $cantidad_entrega;
                    $lugar_entrega->fecha_entrega = $fecha_entrega[$indice];
                    $lugar_entrega->requisicion_entidad_federativa_id = $entrega_entidad_federativa[$indice];
                    $lugar_entrega->municipio = $entrega_municipio[$indice];
                    $lugar_entrega->localidad = $entrega_localidad[$indice];
                    $lugar_entrega->requisicion_combustible_id = $select_combustible[$indice];
                    $lugar_entrega->observaciones = $entrega_observaciones[$indice];
                    $lugar_entrega->id_status_delete = 1;
                    $lugar_entrega->iduserCreated = auth()->user()->id;
                    $lugar_entrega->iduserUpdated = auth()->user()->id;
                    $lugar_entrega->save();
                }
        }

        session()->flash('success', 'Información de partida agregada correctamente');
        return redirect()->route('concurso.requisiciones.infopartida', ['partida' => $request->partida_id, 'requisicion' => $request->requisicion_id]);
    }

    // Desactivar equipamiento
    public function desactivarEquipamiento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        RequisicionPartidaEquipamiento::where('id', $request->id)->update($data);

        session()->flash('success', 'El equipamiento se elimino correctamente');
        return redirect()->route('concurso.requisiciones.infopartida', ['partida' => $request->partida_id, 'requisicion' => $request->requisicion_id]);
    }

    // Obtener coberturas
    public function obtenercoberturas(Request $request)
    {
        $coberturas = RequisicionCobertura::where('id_status_delete', 1)->where('requisicion_tipo_transporte_id', $request->id)->get();
        $cadena_cobertura = "";
        foreach ($coberturas as $cobertura) {
            $cadena_cobertura .= '"' . $cobertura->id . '":"' . $cobertura->descripcion . '",';
        }
        $cadena_cobertura = '{' . rtrim($cadena_cobertura, ',') . '}';
        return response()->json(['success' => $cadena_cobertura]);
    }

    // Desactivar aseguramiento
    public function desactivarAseguramiento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        RequisicionPartidaAseguramiento::where('id', $request->id)->update($data);

        session()->flash('success', 'El aseguramiento se elimino correctamente');
        return redirect()->route('concurso.requisiciones.infopartida', ['partida' => $request->partida_id, 'requisicion' => $request->requisicion_id]);
    }

    // Desactivar emplacamiento
    public function desactivarEmplacamiento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        RequisicionPartidaEmplacamiento::where('id', $request->id)->update($data);

        session()->flash('success', 'El emplacamiento se elimino correctamente');
        return redirect()->route('requisiciones.infopartida', ['partida' => $request->partida_id, 'requisicion' => $request->requisicion_id]);
    }

    // Desactivar lugar de entrega
    public function desactivarLugarEntrega(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        RequisicionPartidaLugarEntrega::where('id', $request->id)->update($data);

        session()->flash('success', 'El lugar de entrega se elimino correctamente');
        return redirect()->route('requisiciones.infopartida', ['partida' => $request->partida_id, 'requisicion' => $request->requisicion_id]);
    }
}
