<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Estado;
use App\Models\Cliente\Municipio;
use App\Models\Cliente\ClienteTipoDocumento;
use App\Models\Cliente\ClienteDocumento;

use App\Models\User;
use App\Models\Rol;
use App\Models\RolPermiso;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClienteController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function catalogoCliente()
    {
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = DB::table('municipio')
        ->join('estado', 'estado.id_estado', '=', 'municipio.id_estado')
        ->where('municipio.id_status_delete', 1)
        ->get();

        return view('clientes.catalogo-clientes', compact('estados', 'municipios'));
    }

    public function clientedatatable(Request $request)
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
        $totalRecords = Cliente::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Cliente::select('count(*) as allcount')->where('id_cliente', 'like', '%' .$searchValue . '%')->count();

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

        $records = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
            'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
            'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","client.id_estado")
            ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
            ->where('client.id_status_delete', 0)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $valor = "No";
        // Bandera para varlidar si no hay filtros   $valor = "No";
        foreach ($columnName_arr as $indice => $columna){
            if($columna['data']=='rfc'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
                        'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
                        'es.estado_nombre', 'mu.municipio_nombre')
                        ->leftjoin("estado as es","es.id_estado","client.id_estado")
                        ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
                        ->where('client.id_status_delete', 1)
                        ->where('client.rfc', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='razon_social'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
                        'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
                        'es.estado_nombre', 'mu.municipio_nombre')
                        ->leftjoin("estado as es","es.id_estado","client.id_estado")
                        ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
                        ->where('client.id_status_delete', 1)
                        ->where('client.razon_social', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='id_estado'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
                        'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
                        'es.estado_nombre', 'mu.municipio_nombre')
                        ->leftjoin("estado as es","es.id_estado","client.id_estado")
                        ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
                        ->where('client.id_status_delete', 1)
                        ->where('client.id_estado', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

            if($columna['data']=='id_municipio'){
                if (!empty($columna['search']['value'])){
                    $valor = trim($columna['search']['value']);
                    $records = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
                        'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
                        'es.estado_nombre', 'mu.municipio_nombre')
                        ->leftjoin("estado as es","es.id_estado","client.id_estado")
                        ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
                        ->where('client.id_status_delete', 1)
                        ->where('client.id_municipio', 'like', '%' .$valor . '%')
                        ->orderBy($order_column_name, $order_column_dir)
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();
                }
            }

        }

        if($valor == "No"){
            $records = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
            'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
            'es.estado_nombre', 'mu.municipio_nombre')
            ->leftjoin("estado as es","es.id_estado","client.id_estado")
            ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
            ->where('client.id_status_delete', 1)
            ->orderBy($order_column_name, $order_column_dir)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }else{
            $totalRecords = count($records);
            $totalRecordswithFilter = count($records);
        }

        $data_arr = array();
        $pro="";
        foreach($records as $record){

            $data_arr[] = array(
                "id" => $record->id,
                "rfc" => $record->rfc,
                "razon_social" =>$record->razon_social,
                "alias" => $record->alias,
                "calle_numero" => $record->calle_numero,
                "colonia" => $record->colonia,
                "id_municipio" => $record->municipio_nombre,
                "id_estado" => $record->estado_nombre,
                "codigo_postal" => $record->codigo_postal,
                "permisos" => $permiso_array,
                'acciones'=>null,
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

    public function agregarCliente()
    {
        $estados = Estado::orderBy('id_estado', 'asc')->where('id_status_delete', 1)->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->where('id_status_delete', 1)->get();

        $documentos = ClienteTipoDocumento::where('id_status_delete',1)->get();

        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documentos as $documento){
            $cadenaTipoDocumento .= '"'.$documento->id.'":"'.$documento->tipo.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';


        return view('clientes.agregar-cliente', compact('estados', 'municipios','cadenaTipoDocumento'));
    }

    public function guardarCliente(Request $request)
    {

        $validated = $request->validate([
            'razon_social' => 'required'
        ]);

        $data = [
            'rfc' => $request->rfc,
            'razon_social' => $request->razon_social,
            'alias' => $request->alias,
            'calle_numero' => $request->calle_numero,
            'colonia' => $request->colonia,
            'codigo_postal' => $request->codigo_postal,
            'id_municipio' => $request->id_municipio,
            'id_estado' => $request->id_estado,
            'cedula_fiscal' => $request->cedula_fiscal,  
            'id_status_delete' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserCreated' =>auth()->user()->id,
            'iduserUpdated' =>auth()->user()->id,
        ];
        $id_cliente = Cliente::insertGetId($data);

        $colIdDocumento = $request->id_documento;
        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('cliente/'.$id_cliente, $archivo, $archivoNombre);
                $data = [
                    'id_cliente' => $id_cliente,
                    'cliente_tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                ClienteDocumento::insert($data);
            }
        }

        session()->flash('success', 'El cliente se añadió correctamente');
        return redirect()->route('cliente.catalogoCliente');

    }

    public function vistaeditarCliente($id_cliente)
    {

        $cliente = Cliente::where('id_cliente', $id_cliente)
            ->join('municipio', 'client.id_municipio', '=', 'municipio.id_municipio')
            ->join('estado', 'client.id_estado', '=', 'estado.id_estado')
            ->select('client.*', 'municipio.*', 'estado.*')
            ->first();
        $estados = Estado::orderBy('id_estado', 'asc')->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->get();

        $documento = ClienteTipoDocumento::where('id_status_delete',1)->get();
        //tipo de documentos en formato json
        $cadenaTipoDocumento = "";
        foreach($documento as $doc){
            $cadenaTipoDocumento .= '"'.$doc->id.'":"'.$doc->tipo.'",';
        }
        $cadenaTipoDocumento = '{'.rtrim($cadenaTipoDocumento, ',').'}';

        $documentos = ClienteDocumento::where('id_cliente',$id_cliente)->get();

        return view('clientes.editar-cliente', compact('cliente','estados', 'municipios','cadenaTipoDocumento','documentos'));

    }

    public function editarCliente(Request $request)
    {

        $validated = $request->validate([
            'razon_social' => 'required',
        ]);

        $data = [
            'rfc' => $request->rfc,
            'razon_social' => $request->razon_social,
            'alias' => $request->alias,
            'calle_numero' => $request->calle_numero,
            'colonia' => $request->colonia,
            'codigo_postal' => $request->codigo_postal,
            'id_municipio' => $request->id_municipio,
            'id_estado' => $request->id_estado,
            'cedula_fiscal' => $request->cedula_fiscal, 
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s'),
            'iduserUpdated' =>auth()->user()->id,
        ];

        Cliente::where('id_cliente', $request->id_cliente)->update($data);


        $colIdDocumento = $request->id_documento;
        $cliente = Cliente::where('rfc', $request->rfc)->first();

        if($request->hasfile('archivo')){
            $archivos = $request->file('archivo');
            foreach($archivos as $indice => $archivo)
            {
                $archivoNombre = $archivo->hashName();
                $mimeType = $archivo->getMimeType();
                Storage::putFileAs('cliente/'.$cliente->id_cliente, $archivo, $archivoNombre);
                $data = [
                    'id_cliente' => $cliente->id_cliente,
                    'cliente_tipo_documento_id' =>$colIdDocumento[$indice],
                    'documento' => $archivoNombre,
                    'mime_type' => $mimeType,
                    'created_at' =>date('Y-m-d H:i:s'),
                    'updated_at' =>date('Y-m-d H:i:s'),
                    'iduserCreated' =>auth()->user()->id,
                    'iduserUpdated' =>auth()->user()->id
                ];
                ClienteDocumento::insert($data);
            }
        }



        session()->flash('success', 'El cliente se actualizó correctamente');
        return redirect()->route('cliente.catalogoCliente');

    }

    public function eliminardocumentocliente(Request $request)
    {
        $doc = ClienteDocumento::findOrFail($request->id);
        $estatus = true;
        if ($doc){
            Storage::delete('cliente/'.$doc->id_cliente.'/'.$doc->documento);
            ClienteDocumento::where('id', $request->id)->delete();
        }else{
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }


    public function catalogoClientesinactivos()
    {
        $clientes = Cliente::select('client.id_cliente as id', 'client.rfc', 'client.razon_social', 'client.alias',
            'client.calle_numero', 'client.colonia', 'client.codigo_postal', 'client.id_municipio', 'client.id_estado',
            'es.estado_nombre', 'mu.municipio_nombre', 'client.motivo_desactivar',)
            ->leftjoin("estado as es","es.id_estado","client.id_estado")
            ->leftjoin("municipio as mu", "mu.id_municipio", "client.id_municipio")
            ->where('client.id_status_delete',2)
            ->get();

        $documentos = ClienteTipoDocumento::where('id_status_delete',1)->get();

        return view('clientes.catalogo-clientes-inactivos', compact('clientes'));
    }

    public function eliminarcliente(Request $request)
    {
        $data = [
            'id_status_delete' => 2,
            'motivo_desactivar' => $request->motivo,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Cliente::where('id_cliente', $request->id)->update($data);

        session()->flash('success', 'El cliente se desactivo correctamente');
        return redirect()->route('cliente.catalogoCliente');
    }

    public function activarcliente(Request $request)
    {
        $data = [
            'id_status_delete' => 1,
            'updated_at' =>date('Y-m-d H:i:s')
        ];

        Cliente::where('id_cliente', $request->id)->update($data);

        session()->flash('success', 'El cliente se activo correctamente');
        return redirect()->route('cliente.catalogoClientesinactivos');
    }

    public function verCliente($id_cliente)
    {
        $cliente = Cliente::where('id_cliente', $id_cliente)
            ->join('municipio', 'client.id_municipio', '=', 'municipio.id_municipio')
            ->join('estado', 'client.id_estado', '=', 'estado.id_estado')
            ->select('client.*', 'municipio.*', 'estado.*')
            ->first();
        $estados = Estado::orderBy('id_estado', 'asc')->get();
        $municipios = Municipio::orderBy('id_municipio', 'asc')->get();
        $documentos = ClienteDocumento::where('id_cliente',$id_cliente)->get();

        return view('clientes.ver-cliente', compact('cliente','estados', 'municipios','documentos'));
    }

    public function obtenermunicipios(Request $request)
    {
        $municipios = Municipio::where('id_status_delete', 1)->where('id_estado', $request->id)->get();
        $cadena_municipio = "";
        foreach ($municipios as $mun) {
            $cadena_municipio .= '"' . $mun->id_municipio . '":"' . $mun->municipio_nombre . '",';
        }
        $cadena_municipio = '{' . rtrim($cadena_municipio, ',') . '}';
        return response()->json(['success' => $cadena_municipio]);
    }

}
