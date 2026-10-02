<?php

namespace App\Http\Controllers\Segmento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\Segmento\Accesorios;
use App\Models\Segmento\Blindaje;
use App\Models\Segmento\Capacidad;
use App\Models\Segmento\Carroceria;
use App\Models\Segmento\Cilindro;
use App\Models\Segmento\Direccion;
use App\Models\Segmento\EnInventario;
use App\Models\Segmento\EspejosLaterales;
use App\Models\Segmento\Gps;
use App\Models\Segmento\LantaRefaccion;
use App\Models\Segmento\Motor;
use App\Models\Segmento\NoCilindro;
use App\Models\Segmento\Pasajero;
use App\Models\Segmento\Potencia;
use App\Models\Segmento\Puerta;
use App\Models\Segmento\Radio;
use App\Models\Segmento\TipoVehiculo;
use App\Models\Segmento\Transmision;
use App\Models\Segmento\Segmento;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SegmentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listadosegmentos()
    {

        $carroceria = Carroceria::where('id_status_delete', 1)->get();
        $motor = Motor::where('id_status_delete', 1)->get();
        $puerta = Puerta::where('id_status_delete', 1)->get();
        $tipovehiculo = TipoVehiculo::where('status_delete', 1)->get();
        $transmision = Transmision::where('id_status_delete', 1)->get();

        return view('segmentos.catalogo-segmentos', compact('carroceria', 'motor', 'puerta', 'tipovehiculo', 'transmision'));
    }

    public function segmentodatatable(Request $request)
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

        // Total records
        $totalRecords = Pasajero::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Pasajero::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();

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

        $records = Segmento::select(
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
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage);


        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna) {
            if ($columna['data'] == 'tipo_vehiculo_id') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Segmento::select(
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
                        ->where("segmentos.tipo_vehiculo_id", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }
            if ($columna['data'] == 'carroceria') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Segmento::select(
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
                        ->where("segmentos.carroceria_id", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }
            if ($columna['data'] == 'motor_id') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Segmento::select(
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
                        ->where("segmentos.motor_id", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }
            if ($columna['data'] == 'transmision_id') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Segmento::select(
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
                        ->where("segmentos.transmision_id", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }
            if ($columna['data'] == 'puerta_id') {
                if (!empty($columna['search']['value'])) {
                    $valor = trim($columna['search']['value']);

                    $records = Segmento::select(
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
                        ->where("segmentos.puerta_id", '=', $valor)
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }
        }

        if ($valor == "No") {
            $records = Segmento::select(
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
                ->orderBy($order_column_name, $order_column_dir)
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $pro = "";
        foreach ($records as $record) {

            $data_arr[] = array(
                "id" => $record->id,
                "tipo_vehiculo_id" => $record->tipo_vehiculo,
                "carroceria" => $record->carroceria,
                "motor_id" => $record->motor,
                "transmision_id" => $record->transmision,
                "puerta_id" => $record->puertas,
                "permisos" => $permiso_array,
                'acciones' => null,
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

    public function crearsegmento()
    {
        $accesorio = Accesorios::where('id_status_delete', 1)->get();
        $blindaje = Blindaje::where('id_status_delete', 1)->get();
        $capacidad = Capacidad::where('id_status_delete', 1)->get();
        $carroceria = Carroceria::where('id_status_delete', 1)->get();
        $cilindro = Cilindro::where('id_status_delete', 1)->get();
        $eninventario = EnInventario::where('id_status_delete', 1)->get();
        $espejoslaterales = EspejosLaterales::where('id_status_delete', 1)->get();
        $gps = Gps::where('id_status_delete', 1)->get();
        $lantarefaccion = LantaRefaccion::where('id_status_delete', 1)->get();
        $motor = Motor::where('id_status_delete', 1)->get();
        $nocilindro = NoCilindro::where('id_status_delete', 1)->get();
        $pasajero = Pasajero::where('id_status_delete', 1)->get();
        $potencia = Potencia::where('id_status_delete', 1)->get();
        $puerta = Puerta::where('id_status_delete', 1)->get();
        $radio = Radio::where('id_status_delete', 1)->get();
        $tipovehiculo = TipoVehiculo::where('status_delete', 1)->get();
        $transmision = Transmision::where('id_status_delete', 1)->get();
        $direccion = Direccion::where('id_status_delete', 1)->get();
        $segmentos = Segmento::where('id_status_delete', 1)->get();

        return view('segmentos.crear-segmento', compact('accesorio', 'blindaje', 'capacidad', 'carroceria', 'cilindro', 'eninventario', 'espejoslaterales', 'gps', 'lantarefaccion', 'motor', 'nocilindro', 'pasajero', 'potencia', 'puerta', 'radio', 'tipovehiculo', 'transmision', 'direccion'));
    }

    public function guardarsegmento(Request $request)
    {

        $data = [
            'id_status_delete' => 1,
            'tipo_vehiculo_id' => $request->tipo_vehiculo,
            'puerta_id' => $request->puertas,
            'carroceria_id' => $request->carroceria,
            'no_cilindro_id' => $request->no_cilindros,
            'cilindro_id' => 1,
            'pasajero_id' => $request->pasajeros,
            'motor_id' => $request->motor,
            'capacidad_id' => $request->capacidad,
            'llanta_refaccion_id' => $request->llanta_refaccion,
            'espejos_laterales' => $request->espejos_laterales ? implode(",", $request->espejos_laterales) : null,
            'accesorios' => $request->accesorios ?  implode(",", $request->accesorios) : null,
            'potencia_id' => $request->potencia,
            'transmision_id' => $request->transmision,
            'gps_id' => $request->gps,
            'radio_id' => $request->radio,
            'direccion_id' => $request->direccion,
            'blindaje_id' => $request->blindaje,
            'en_inventario_id' => $request->en_inventario,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        Segmento::insert($data);

        session()->flash('success', 'El segmento se creo correctamente');
        return redirect()->route('segmento.catalogosegmentos');
    }

    public function editarsegmento($segmento)
    {
        $accesorio = Accesorios::where('id_status_delete', 1)->get();
        $blindaje = Blindaje::where('id_status_delete', 1)->get();
        $capacidad = Capacidad::where('id_status_delete', 1)->get();
        $carroceria = Carroceria::where('id_status_delete', 1)->get();
        $cilindro = Cilindro::where('id_status_delete', 1)->get();
        $eninventario = EnInventario::where('id_status_delete', 1)->get();
        $espejoslaterales = EspejosLaterales::where('id_status_delete', 1)->get();
        $gps = Gps::where('id_status_delete', 1)->get();
        $lantarefaccion = LantaRefaccion::where('id_status_delete', 1)->get();
        $motor = Motor::where('id_status_delete', 1)->get();
        $nocilindro = NoCilindro::where('id_status_delete', 1)->get();
        $pasajero = Pasajero::where('id_status_delete', 1)->get();
        $potencia = Potencia::where('id_status_delete', 1)->get();
        $puerta = Puerta::where('id_status_delete', 1)->get();
        $radio = Radio::where('id_status_delete', 1)->get();
        $tipovehiculo = TipoVehiculo::where('status_delete', 1)->get();
        $transmision = Transmision::where('id_status_delete', 1)->get();
        $direccion = Direccion::where('id_status_delete', 1)->get();
        $segmento_info = Segmento::where('id', $segmento)->get();

        return view('segmentos.editar-segmento', compact('accesorio', 'blindaje', 'capacidad', 'carroceria', 'cilindro', 'eninventario', 'espejoslaterales', 'gps', 'lantarefaccion', 'motor', 'nocilindro', 'pasajero', 'potencia', 'puerta', 'radio', 'tipovehiculo', 'transmision', 'direccion', 'segmento_info'));
    }

    public function modificarsegmento(Request $request)
    {

        $data = [
            'id_status_delete' => 1,
            'tipo_vehiculo_id' => $request->tipo_vehiculo,
            'puerta_id' => $request->puertas,
            'carroceria_id' => $request->carroceria,
            'no_cilindro_id' => $request->no_cilindros,
            'cilindro_id' => 1,
            'pasajero_id' => $request->pasajeros,
            'motor_id' => $request->motor,
            'capacidad_id' => $request->capacidad,
            'llanta_refaccion_id' => $request->llanta_refaccion,
            'espejos_laterales' => $request->espejos_laterales ? implode(",", $request->espejos_laterales) : null,
            'accesorios' => $request->accesorios ?  implode(",", $request->accesorios) : null,
            'potencia_id' => $request->potencia,
            'transmision_id' => $request->transmision,
            'gps_id' => $request->gps,
            'radio_id' => $request->radio,
            'direccion_id' => $request->direccion,
            'blindaje_id' => $request->blindaje,
            'en_inventario_id' => $request->en_inventario,
            'iduserCreated' => auth()->user()->id,
            'iduserUpdated' => auth()->user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        Segmento::where('id', $request->id)->update($data);

        session()->flash('success', 'El segmento se modifico correctamente');
        return redirect()->route('segmento.catalogosegmentos');
    }

    public function desactivarsegmento(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'iduserUpdated' => auth()->user()->id,
            'motivo_desactivar' => $request->motivo,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Segmento::where('id', $request->id)->update($data);

        session()->flash('success', 'El segmento se desactivo correctamente');
        return redirect()->route('segmento.catalogosegmentos');
    }

    public function catalogosegmentosinactivos()
    {
        $records = Segmento::select(
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
            'sp.puertas',
            'segmentos.motivo_desactivar'
        )
            ->leftjoin("segmento_tipo_vehiculo as tv", "tv.id", "segmentos.tipo_vehiculo_id")
            ->leftjoin("segmento_carroceria as sc", "sc.id", "segmentos.carroceria_id")
            ->leftjoin("segmento_motor as sm", "sm.id", "segmentos.motor_id")
            ->leftjoin("segmento_transmision as st", "st.id", "segmentos.transmision_id")
            ->leftjoin("segmento_puerta as sp", "sp.id", "segmentos.puerta_id")
            ->where('segmentos.id_status_delete', 2)
            ->get();

        return view('segmentos.catalogo-segmentos-inactivos', compact('records'));
    }

    public function activarsegmento(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'iduserUpdated' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        Segmento::where('id', $request->id)->update($data);

        session()->flash('success', 'El segmento se activo correctamente');
        return redirect()->route('segmento.catalogosegmentosinactivos');
    }
}
