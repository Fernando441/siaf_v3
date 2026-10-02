<?php

namespace App\Http\Controllers\Licitacion;

use App\Http\Controllers\Controller;
use App\Models\Licitacion\LicitacionPrioridad;
use App\Services\Folio;
use App\Services\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Licitacion\LicitacionGestorDocumentos;
use App\Models\Licitacion\LicitacionGestorTipoDocumento;
use App\Models\Licitacion\LicitacionGestorDocumentosYear;

class GestorDocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function catalogoDocumento()
    {
        $documentos = LicitacionGestorTipoDocumento::all();
        $tipoDocumentos = LicitacionGestorTipoDocumento::all();
        $jsonTipoDocumentos = "";
        foreach ($documentos as $documento) {
            $jsonTipoDocumentos .= '"' . $documento->id . '":"' . $documento->informacion . '",';
        }
        $jsonTipoDocumentos = '{' . rtrim($jsonTipoDocumentos, ',') . '}';

        return view('licitaciones.gestordocumentos.catalogo-documentos', compact('jsonTipoDocumentos', 'tipoDocumentos'));
    }

    public function gestorDatatable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');
        $documentoSearch = $request->get('search');
        $tipoDocumentoSearch = $request->get('tipoDocumento');
        $yearSearch = $request->get('year');
        $monthSearch = $request->get('month');
        $daySearch = $request->get('day');
        $mostrarArchivosSubidosPorMi = $request->get('mostrarArchivosSubidosPorMi');

        // Total records
        $totalRecords = LicitacionGestorDocumentos::all()->count();
        $totalRecordswithFilter = LicitacionGestorDocumentos::select('count(*) as allcount')->count();

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

        $query = LicitacionGestorDocumentos::select('*');

    
        if ($mostrarArchivosSubidosPorMi == "true") {
            $query->where('iduserCreated', Auth::user()->id);
        }

        if (!empty($documentoSearch)) {
            $query->where('documento', 'like', '%' . $documentoSearch . '%');
        }

        if (!empty($tipoDocumentoSearch)) {
            $query->whereHas('licitacionGestorTipoDocumento', function ($query) use ($tipoDocumentoSearch) {
                $query->where('informacion', 'like', '%' . $tipoDocumentoSearch . '%');
            });
        }

        if (!empty($documentoSearch)) {
            $query->orWhere('comentario', 'like', '%' . $documentoSearch . '%');
        }

        if (!empty($yearSearch)) {
            $query->whereYear('fecha', '=', $yearSearch);
        }

        if (!empty($monthSearch)) {
            $query->whereMonth('fecha', '=', $monthSearch);
        }

        if (!empty($daySearch)) {
            $query->whereDay('fecha', '=', $daySearch);
        }

        $totalRecordswithFilter = $query->count();

        $records = $query->orderBy($order_column_name, $order_column_dir)
            ->skip($start)->take($rowperpage)->get();

        $data_arr = array();
        foreach ($records as $record) {

            if (!empty($record->size)) {
                $unidades = ['bytes', 'KB', 'MB', 'GB'];
                $factor = floor((strlen($record->size) - 1) / 3);
                $size = sprintf("%.2f", $record->size / pow(1024, $factor)) . ' ' . $unidades[$factor];
            } else {
                $size = Storage::exists($record->documento) ? Storage::size($record->documento) : 'No existe el archivo';
            }

            $data_arr[] = array(
                "id" => $record->id,
                "documento" => $record->documento,
                "size" => $size,
                "licitacion_gestor_tipo_documento_id" => $record->licitacionGestorTipoDocumento->informacion,
                "comentario" => $record->comentario,
                "fecha" => $record->fecha,
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

    public function guardarDocumento(Request $request)
    {
        if ($request->hasfile('archivo')) {

            $archivos = $request->file('archivo');
            $colIdDocumento = $request->id_tipo_documento;
            $colIdComentario = $request->id_tipo_comentario;
            $colIdFecha = $request->id_fecha;


            foreach ($archivos as $indice => $archivo) {

                // Validacion de extensiones permitidas
                $extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar', '7z'];
                $extensionArchivo = $archivo->getClientOriginalExtension();
                if (!in_array($extensionArchivo, $extensionesPermitidas)) {
                    return redirect()->back()->with('error', 'El archivo ' . $archivo->getClientOriginalName() . ' no es permitido');
                }

                $archivoNombre = $archivo->hashName();
                Storage::putFileAs('gestordocumentos/', $archivo, $archivoNombre);
                $tipo_documento = $colIdDocumento[$indice];
                $comentario = $colIdComentario[$indice];
                $fecha = $colIdFecha[$indice];
                $fecha = Carbon::createFromFormat('d/m/Y H:i', $fecha)->format('Y-m-d H:i:s');

                $year = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('Y');
                $month = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('m');
                $day = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('d');

                $yearExist = LicitacionGestorDocumentosYear::where('year', $year)->first();

                if ($yearExist) {
                    $yearId = $yearExist->id;
                } else {
                    $yearId = LicitacionGestorDocumentosYear::insertGetId([
                        'year' => $year,
                    ]);
                }


                $data = [
                    'documento' => $archivoNombre,
                    'licitacion_gestor_tipo_documento_id' => $tipo_documento,
                    'comentario' => $comentario,
                    'fecha' => $fecha,
                    'licitacion_gestor_documentos_year_id' => $yearId,
                    'month' => $month,
                    'day' => $day,
                    'size' => $archivo->getSize(),
                    'mine_type' => $archivo->getMimeType(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];

                LicitacionGestorDocumentos::insert($data);
            }
        }

        if (!$request->hasfile('archivo')) {
            return redirect()->back()->with('error', 'No se ha subido ningun archivo');
        }

        session()->flash('success', 'El documento se creo correctamente');
        return redirect()->route('gestordocumentos.catalogodocumento');
    }

    public function gestorEliminarDocumento(Request $request)
    {

        $id = $request->id;

        $archivo = LicitacionGestorDocumentos::where('id', $id)->first();
        $documento = $archivo->documento;
        Storage::delete('gestordocumentos/' . $documento);
        LicitacionGestorDocumentos::where('id', $id)->delete();
        $estatus = true;


        return response()->json([
            'estatus' => $estatus,
        ]);
    }

    // exploradorArchivos
    public function exploradorArchivos()
    {
        $tipoDocumentos = LicitacionGestorTipoDocumento::all();

        return view('gestordocumentos.explorador-archivos', compact('tipoDocumentos'));
    }
}
