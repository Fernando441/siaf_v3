<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Licitacion\Licitacion;
use App\Models\Licitacion\ProposicionEconomica;
use App\Models\Licitacion\LicitacionSegmento;
use App\Models\Segmento\Segmento;
use App\Models\Licitacion\Afianzadora;
use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProposicionEconomicaController extends Controller
{
    protected $money_format;
    public function __construct(Money $money_format)
    {
        $this->middleware('auth');
        $this->money_format = $money_format;
    }

    public function listadoproposicioneconomica()
    {
        $proposicioneconomica = LicitacionSegmento::get();

        return view('licitaciones.proposicioneconomica.catalogo-proposicion-economica', compact('proposicioneconomica'));
    }

    public function proposicioneconomicadatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = LicitacionSegmento::select('count(*) as allcount')->count();
        $totalRecordswithFilter = LicitacionSegmento::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();
        // Fetch records
        $records = LicitacionSegmento::select(
            'licitacion_segmento.id',
            'licitacion_segmento.licitacion_id',
            'licitacion_segmento.observaciones',
            'li.folio',
            'li.titulo_servicio',
            "li.id as licid"
        )
            ->leftjoin("licitaciones as li", "li.id", "licitacion_segmento.licitacion_id")
            ->skip($start)
            ->take($rowperpage);

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'nombre') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);
                    $records = $records->where("li.folio", '=', $valor);
                }
            }
        }

        if ($valor == "No") {
            $records = $records->get();
        } else {
            $records = $records->get();
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $pro = "";
        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "nombre" => $record->folio,
                "titulo_servicio" => $record->titulo_servicio,
                "observaciones" => $record->observaciones,
                'acciones' => null,
                "licid" => $record->licid,
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

    public function crearpoposicioneconomica($lici, $redirect, $contrato)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }
        // dd($permiso_array);

        $segmento = Segmento::select(
            'segmentos.id',
            'segmentos.tipo_vehiculo_id',
            'segmentos.puerta_id',
            'segmentos.carroceria_id',
            'segmentos.id_status_delete',
            'segmentos.no_cilindro_id',
            'segmentos.cilindro_id',
            'segmentos.pasajero_id',
            'segmentos.motor_id',
            'segmentos.capacidad_id',
            'segmentos.transmision_id',
            'tv.tipo_vehiculo',
            'sc.carroceria',
            'sm.motor',
            'st.transmision',
            'sp.puertas'
        )
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "segmentos.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "segmentos.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "segmentos.motor_id")
            ->leftjoin("segmento_transmision as st", "st.id", "segmentos.transmision_id")
            ->leftjoin("segmento_puerta as sp", "sp.id", "segmentos.puerta_id")
            ->where('segmentos.id_status_delete', 1)
            ->get();

        $licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'licitaciones.contratacion',
            'licitaciones.acto_fallo',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->where("licitaciones.id", $lici)
            ->get();

        $propuesta = LicitacionSegmento::where('licitacion_id', $lici)->first();

        if (empty($propuesta)) {
            $op = 0;
        } else {
            $op = 1;
        }
        $segmentos_select = ProposicionEconomica::select('licitacion_proposicion_economica.segmento_id')->where('licitacion_id', $lici)->get();
        $data = array();
        foreach ($segmentos_select as $key => $value) {
            $data[] = $value->segmento_id;
        }

        $proposicion_economica = ProposicionEconomica::where('licitacion_id', $lici)->get();
        if (count($proposicion_economica) > 0) {
            $propuestaEconomica = true;
        } else {
            $propuestaEconomica = false;
        }

        // dd($licitacion);

        return view('licitaciones.proposicioneconomica.crear-proposicion-economica', compact('segmento', 'licitacion', 'propuesta', 'segmentos_select', 'op', 'data', 'redirect', 'propuestaEconomica', 'contrato', 'permiso_array'));
    }

    public function guardarproposicioneconomica(Request $request)
    {

        if ($request->op == 0) {
            $data = [
                'licitacion_id' => $request->licitacion_id,
                'observaciones' => $request->observaciones,
                'afianzadoras_id' => 1,
                'precio_cotizar' => $request->precio_cotizar,
                'precio_cotizar_diario' => $request->precio_cotizar_diario,
                'precio_cotizar_mes' => $request->precio_cotizar_mes,
                'precio_cotizar_anual' => $request->precio_cotizar_anual,
                'iduserCreated' => auth()->user()->id,
                'iduserUpdated' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            LicitacionSegmento::insert($data);
        } else {
            $data = [
                'precio_cotizar' => $request->precio_cotizar,
                'precio_cotizar_diario' => $request->precio_cotizar_diario,
                'precio_cotizar_mes' => $request->precio_cotizar_mes,
                'precio_cotizar_anual' => $request->precio_cotizar_anual,
                'observaciones' => $request->observaciones,
                'iduserUpdated' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            LicitacionSegmento::where('licitacion_id', $request->licitacion_id)->update($data);;
        }

        $id = LicitacionSegmento::where("licitacion_id", $request->licitacion_id)->get();
        $segmentos_select = ProposicionEconomica::where("licitacion_id", $request->licitacion_id)->get();

        $id_segmentos = array();
        foreach ($segmentos_select as $clave => $select) {
            $id_segmentos[] = $select->segmento_id;
        }

        if ($request->segmento != null) {
            foreach ($request->segmento as $segmento) {
                if (in_array($segmento, $id_segmentos)) {
                    // el segmento ya esta registrado
                } else {
                    $data = [
                        'licitacion_id' => $request->licitacion_id,
                        'segmento_id' => $segmento,
                        'iduserCreated' => auth()->user()->id,
                        'iduserUpdated' => auth()->user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    ProposicionEconomica::insert($data);
                }
            }   // Insertar segmentos 

            foreach ($segmentos_select as $segmento) {
                if (!in_array($segmento->segmento_id, $request->segmento)) {
                    ProposicionEconomica::where("id", $segmento->id)->delete();
                }
            } // Eliminar segmentos
        } else {
            foreach ($segmentos_select as $segmento) {
                ProposicionEconomica::where("id", $segmento->id)->delete();
            } // Eliminar segmentos

        }

        // session()->flash('success', 'La proposición economica se creo correctamente');
        if($request->tipo_contrato == 1){
            return redirect()->route('proposicioneconomica.editarproposicioneconomica', [$id[0]->id, $request->redirect,$request->tipo_contrato]);
        }else{
            return redirect()->route('proposicioneconomica.editarproposicioneconomicacon', [$id[0]->id, $request->redirect,$request->tipo_contrato]);
        }
        
    }

    // Contrato Cerrado
    public function editarpoposicioneconomica($proposicion, $redirect, $contrato)
    {


        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }
        // dd($permiso_array);

        $proposicioneconomica = LicitacionSegmento::where("id", $proposicion)->get();
        $segmento = ProposicionEconomica::select(
            'licitacion_proposicion_economica.id',
            'licitacion_proposicion_economica.licitacion_id',
            'licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad',
            'licitacion_proposicion_economica.precio_unitario',
            'licitacion_proposicion_economica.partida',
            'tv.tipo_vehiculo',
            'sc.carroceria',
            'sm.motor',
            'st.transmision'
        )
            ->leftjoin("segmentos as sg", "sg.id", "licitacion_proposicion_economica.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "sg.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "sg.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "sg.motor_id")
            ->leftjoin("segmento_transmision as st", "st.id", "sg.transmision_id")
            ->where("licitacion_proposicion_economica.licitacion_id", $proposicioneconomica[0]->licitacion_id)
            ->get();

        $licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'licitaciones.contratacion',
            'licitaciones.acto_fallo',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->where("licitaciones.id", $proposicioneconomica[0]->licitacion_id)
            ->get();

        $afianzadora = Afianzadora::where("id_status_delete", 1)->get();

        return view('licitaciones.proposicioneconomica.editar-proposicion-economica', compact('segmento', 'licitacion', 'proposicioneconomica', 'redirect', 'afianzadora', 'permiso_array', 'proposicion', 'contrato'));
    }

    // Contrato Abierto
    public function editarpoposicioneconomicacon($proposicion, $redirect, $contrato)
    {

        $user = User::where('id', auth()->user()->id)->first();
        $permisos = RolPermiso::where('role_id', $user->role)->get();
        $permiso_array = array();
        foreach ($permisos as $key => $value) {
            $permiso_array[] = $value->permission_id;
        }
        // dd($permiso_array);

        $proposicioneconomica = LicitacionSegmento::where("id", $proposicion)->get();

        $segmento = ProposicionEconomica::select(
            'licitacion_proposicion_economica.id',
            'licitacion_proposicion_economica.licitacion_id',
            'licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad',
            'licitacion_proposicion_economica.precio_unitario',
            'licitacion_proposicion_economica.precio_unitario_maximo',
            'licitacion_proposicion_economica.cantidad_maxima',
            'licitacion_proposicion_economica.partida',
            'tv.tipo_vehiculo',
            'sc.carroceria',
            'sm.motor',
            'st.transmision'
        )
            ->leftjoin("segmentos as sg", "sg.id", "licitacion_proposicion_economica.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "sg.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "sg.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "sg.motor_id")
            ->leftjoin("segmento_transmision as st", "st.id", "sg.transmision_id")
            ->where("licitacion_proposicion_economica.licitacion_id", $proposicioneconomica[0]->licitacion_id)
            ->get();

        $licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'licitaciones.contratacion',
            'licitaciones.acto_fallo',
            'licitaciones.tipo_contrato'
        )
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->where("licitaciones.id", $proposicioneconomica[0]->licitacion_id)
            ->get();

        $afianzadora = Afianzadora::where("id_status_delete", 1)->get();

        return view('licitaciones.proposicioneconomica.editar-proposicion-economica-abierto', compact('segmento', 'licitacion', 'proposicioneconomica', 'redirect', 'afianzadora', 'permiso_array', 'proposicion', 'contrato'));
    }

    public function modificarproposicioneconomica(Request $request)
    {
        // dd($request);
        if($request->op_economica == 1){
            for ($i = 0; $i < count($request->segmento); $i++) {
                $data = [
                    'id' => $request->segmento[$i],
                    'partida' => $request->partida[$i],
                    'cantidad' => $request->cantidad[$i],
                    'precio_unitario' => $request->precio_unitario[$i] ? $this->money_format->clearFormat($request->precio_unitario[$i]) : null,
                    'cantidad_maxima' => $request->cantidad_maxima[$i],
                    'precio_unitario_maximo' => $request->precio_unitario[$i] ? $this->money_format->clearFormat($request->precio_unitario[$i]) : null,
                    'iduserUpdated' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                ProposicionEconomica::where('id', $request->segmento[$i])->update($data);
            }
        }else{
            for ($i = 0; $i < count($request->segmento); $i++) {
                $data = [
                    'id' => $request->segmento[$i],
                    'partida' => $request->partida[$i],
                    'cantidad' => $request->cantidad[$i],
                    'cantidad_maxima' => "",
                    'precio_unitario' => $request->precio_unitario[$i] ? $this->money_format->clearFormat($request->precio_unitario[$i]) : null,
                    'iduserUpdated' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                ProposicionEconomica::where('id', $request->segmento[$i])->update($data);
            }    
        }


        $data = [
            'observaciones' => $request->observaciones,
            // 'precio_cotizar'=> $request->precio_cotizar,
            // 'numero_sostenibilidad' => $request->numero_sostenibilidad,
            // 'importe' => $request->importe ? $this->money_format->clearFormat($request->importe) : null,
            // 'vigencia_fianza' => $request->vigencia_fianza ? Carbon::createFromFormat('d/m/Y', $request->vigencia_fianza)->format('Y-m-d') : null,
            // 'afianzadoras_id' => $request->nombre_afianzadora,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        LicitacionSegmento::where('licitacion_id', $request->licitacion_id)->update($data);

        session()->flash('success', 'La proposición economica se modifico correctamente');
        if ($request->redirect == 1) {
            return redirect()->route('proposicioneconomica.crearproposicioneconomica', [$request->licitacion_id, $request->ref_redirect, $request->ref_contrato]);
        } else {
            return redirect()->route('proposicioneconomica.catalogoproposicioneconomica');
        }
    }

    public function eliminarpropuesta(Request $request)
    {

        $propuesta = LicitacionSegmento::where('id', $request->id)->get();

        foreach ($propuesta as $key) {
            ProposicionEconomica::where("licitacion_id", $propuesta[0]->licitacion_id)->delete();
        }
        $segmentos = ProposicionEconomica::where('licitacion_id', $propuesta[0]->licitacion_id)->get();

        LicitacionSegmento::where("licitacion_id", $propuesta[0]->licitacion_id)->delete();

        session()->flash('success', 'La propuesta economica se elimino correctamente');
        return redirect()->route('proposicioneconomica.catalogoproposicioneconomica');
    }

    public function verpoposicioneconomica($proposicion)
    {
        $proposicioneconomica = LicitacionSegmento::where("id", $proposicion)->get();

        $segmento = ProposicionEconomica::select(
            'licitacion_proposicion_economica.id',
            'licitacion_proposicion_economica.licitacion_id',
            'licitacion_proposicion_economica.segmento_id',
            'licitacion_proposicion_economica.cantidad',
            'licitacion_proposicion_economica.precio_unitario',
            'tv.tipo_vehiculo',
            'sc.carroceria',
            'sm.motor',
            'st.transmision'
        )
            ->leftjoin("segmentos as sg", "sg.id", "licitacion_proposicion_economica.segmento_id")
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "sg.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "sg.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "sg.motor_id")
            ->leftjoin("segmento_transmision as st", "st.id", "sg.transmision_id")
            ->where("licitacion_proposicion_economica.licitacion_id", $proposicioneconomica[0]->licitacion_id)
            ->get();

        $licitacion = Licitacion::select(
            'licitaciones.id',
            'licitaciones.folio',
            'licitaciones.titulo_servicio',
            'licitaciones.empresa_dependencia',
            'licitaciones.no_licitacion',
            'licitaciones.fecha_visita',
            'licitaciones.participacion_conjunta',
            'licitaciones.publicacion_licitacion',
            'licitaciones.cliente',
            'cli.razon_social',
            'licitaciones.id_licitacion_prioridad',
            'licitaciones.contratacion'
        )
            ->leftjoin("client as cli", "cli.id_cliente", "licitaciones.cliente")
            ->where("licitaciones.id", $proposicioneconomica[0]->licitacion_id)
            ->get();


        return view('licitaciones.proposicioneconomica.ver-proposicion-economica', compact('segmento', 'licitacion', 'proposicioneconomica'));
    }
}
