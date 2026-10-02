<?php

namespace App\Http\Controllers\Licitacion;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Requisicion\Requisicion;
use Illuminate\Support\Facades\Storage;
use App\Models\Licitacion\RequisicionGrupo;
use App\Models\Licitacion\RequisicionConversion;

class ConversionesController extends Controller
{
    public function listado(Request $request) {
        $requisicionId = $request->id;
        $requisicionGrupo = RequisicionGrupo::select('id', 'descripcion')->where('id_status_delete', 1)->get();
        $documentos = RequisicionConversion::where('requisicion_id', $requisicionId)->get();

        return view('licitaciones.conversiones.listado', compact('requisicionGrupo', 'requisicionId', 'documentos'));
    }

    public function guardarDocumento(Request $request)
    {
        if ($request->hasfile('archivo')) {

            $archivos = $request->file('archivo');
            $conversiones = $request->conversion;
            $cantidades = $request->cantidad;
            $fechas = $request->fecha;
            $requisicionId = $request->requisicion_id;


            foreach ($archivos as $indice => $archivo) {

                // Validacion de extensiones permitidas
                $extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'zip', 'rar', '7z'];
                $extensionArchivo = $archivo->getClientOriginalExtension();
                if (!in_array($extensionArchivo, $extensionesPermitidas)) {
                    return redirect()->back()->with('error', 'Por seguridad, El archivo ' . $archivo->getClientOriginalName() . ' no es permitido, intente de nuevo con archivos permitidos. gracias.');
                }

                $archivoNombre = $archivo->hashName();
                Storage::putFileAs('licitacion_conversion/' . $requisicionId . '/', $archivo, $archivoNombre);
                $conversion = $conversiones[$indice];
                $cantidad = $cantidades[$indice];
                $fecha = $fechas[$indice];
                $fecha = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');

                $data = [
                    'requisicion_id' => $requisicionId,
                    'requisicion_grupo_id' => $conversion,
                    'documento' => $archivoNombre,
                    'mime_type' => $archivo->getMimeType(),
                    'monto' => $cantidad,
                    'fecha' => $fecha,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'iduserCreated' => auth()->user()->id,
                    'iduserUpdated' => auth()->user()->id
                ];

                RequisicionConversion::insert($data);
            }
        }

        if (!$request->hasfile('archivo')) {
            return redirect()->back()->with('error', 'No es posible subir archivos, por favor intente de nuevo');
        }

        session()->flash('success', 'LA compra de conversion se creo correctamente');
        return redirect()->route('conversiones.listado', ['id' => $requisicionId]);
    }

    public function eliminarDocumento(Request $request)
    {
        $doc = RequisicionConversion::findOrFail($request->id);
        $estatus = true;
        if ($doc) {
            Storage::delete('licitacion_conversion/' . $doc->requisicion_id . '/' . $doc->documento);
            RequisicionConversion::where('id', $request->id)->delete();
        } else {
            $estatus = false;
        }

        return response()->json([
            'estatus' => $estatus,
        ]);
    }
}
