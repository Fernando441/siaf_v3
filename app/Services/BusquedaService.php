<?php

namespace App\Services;

use App\Models\Unidad\Unidad;
use App\Models\Unidad\TramiteAseguramientoInfo;
use Illuminate\Support\Facades\DB;

class BusquedaService
{
    protected $consulta = [];
    protected $titulos = [];
    protected $engomado = [
        "Amarillo" => 1,
        "Rosa"     => 2,
        "Rojo"     => 3,
        "Verde"    => 4,
        "Azul"     => 5
    ];

    public function registros($campos, $listado, $tipo): array
    {


        //campos de consulta query directo
        foreach ($campos as $indice => $campo) {
            $campoConsulta = match ($indice) {
                "numero_economico" => "unidad.numero_economico",
                "serie" => "unidad.no_serie",
                "placas" => "unidad.placa",
                "estatus" => "tu.estatus",
                "ubicacion" => "uu.ubicacion",
                "proyecto" => "pr.titulo_servicio",
                "marca" => "mu.nombre_marca",
                "modelo" => "mou.nombre_modelo",
                "anio" => "unidad.unidad_year", 
                "color" => "unidad.color",
                "unidad_tipo" => "uvt.vehiculo_tipo",
                "motor" => "cu.motor",
                "transmision" => "unidad.transmision",
                "fecha_alta" => "cu.fecha_ingreso",
                "fecha_asignacion" => "unidad.fecha_asignacion",
                "kilometraje" => "cu.kilometraje",
                "poliza" => "unidad.no_poliza_seguro",
                "factura" => "unidad.factura_compra",
                "clave_vehicular" => "unidad.clave_vehicular",
                default => null
            };

            if (!empty($campoConsulta)) {
                $this->consulta[] = $campoConsulta;
            }
        }
        
        //campos de filtro query directo
        $consultaResultado = match ($tipo) {
            1 => "unidad.no_serie",
            2 => "unidad.placa",
            3 => "unidad.numero_economico",
            4 => "mu.nombre_marca",
            5 => "mou.nombre_modelo",
            7 => "unidad.op_engomado",
            8 => "unidad.clave_vehicular",
            default => null
        };

        $unidades = Unidad::select(
            $this->consulta
        );
        
        //campos calculados de salida
        foreach ($campos as $indice => $campo) {

            if ($indice == "entidad_federativa") {
                $unidades->addSelect(['entidad' => function ($query) {
                    $query->select('es.estado_nombre')
                        ->from('unidad_tramite_emplacamiento_info as te')
                        ->join("estado as es", "es.id_estado", "te.entidad_placas")
                        ->whereColumn('te.unidad_id', 'unidad.id')
                        ->orderByDesc('fecha')
                        ->limit(1);
                }]);
            }
            
            if ($indice == "color_engomado") {
                $unidades->selectRaw("
                            CASE unidad.op_engomado
                                WHEN 1 THEN 'Amarillo'
                                WHEN 2 THEN 'Rosa'
                                WHEN 3 THEN 'Rojo'
                                WHEN 4 THEN 'Verde'
                                WHEN 5 THEN 'Azul'
                                ELSE NULL
                            END as color_engomado
                        ");
            }
        }

        $unidades->leftjoin("translados_unidad as tu", "tu.unidad_id", "unidad.id");
        $unidades->leftjoin("translados as tr", "tr.id", "tu.translados_id");
        $unidades->leftjoin("marca_unidad as mu", "mu.id", "unidad.id_marca");
        $unidades->leftjoin("modelo_unidad as mou", "mou.id", '=', "unidad.id_modelo");
        $unidades->leftjoin("ubicacion_unidad as uu", "uu.id", '=', "unidad.id_ubicacion");
        $unidades->leftjoin("status_unidad as st", "st.id", '=', "unidad.id_status");
        $unidades->leftjoin("proyectos as pr", "pr.id", '=', "unidad.proyectos_id");
        $unidades->leftjoin("unidad_venta as uv", "uv.id_unidad", '=', "unidad.id");
        $unidades->leftjoin("unidad_vehiculo_tipo as uvt", "uvt.id", '=', "unidad.id_vehiculo_tipo");
        $unidades->leftjoin("complemento_unidad as cu", "cu.id_unidad", '=', "unidad.id");
        $unidades->where("unidad.id_status_delete", 1);

        //filtro subquery por entidad federativa
        if(in_array($tipo, [6]) ){

            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                    ->from('unidad_tramite_emplacamiento_info as te2')
                    ->join("estado as es", "es.id_estado", "te2.entidad_placas")
                    ->whereColumn('te2.unidad_id', 'unidad.id')
                    ->whereIn('es.estado_nombre', $listado);
            });

            //filtro por engomado
        } elseif(in_array($tipo, [7]) ) {
            $listadoColores = $this->convertirColores($listado, $this->engomado);
            $unidades->whereIn($consultaResultado, $listadoColores);
            //filtro por existencia de tramite de emplacamiento
        } elseif(in_array($tipo, [9]) ) {
            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                    ->from('unidad_tramite_emplacamiento_info as te2')
                    ->whereColumn('te2.unidad_id', 'unidad.id');
            });
            //filtro por tenencia y/o pago de derechos
        } elseif(in_array($tipo, [10]) ) {
            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                ->from('unidad_tramite_tenencia_info as tt')
                ->whereColumn('tt.unidad_id', 'unidad.id');
                });    
            //filtro por verificación vehicular                
        } elseif(in_array($tipo, [11]) ) {
            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                ->from('unidad_tramite_verificacion_info as tt')
                ->whereColumn('tt.unidad_id', 'unidad.id');
                });    
            //filtro por aseguramiento    
        } elseif(in_array($tipo, [12]) ) {
            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                ->from('unidad_tramite_aseguramiento_info as tt')
                ->whereColumn('tt.unidad_id', 'unidad.id');
                });            
            //filtro por reemplacamiento    
        } elseif(in_array($tipo, [13]) ) {
            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                ->from('unidad_tramite_reemplacamiento_info as tt')
                ->whereColumn('tt.unidad_id', 'unidad.id');
                });                            
            //filtro cambio de propietario
        } elseif(in_array($tipo, [14]) ) {
            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                ->from('unidad_tramite_cambiopropietario_info as tt')
                ->whereColumn('tt.unidad_id', 'unidad.id');
                });                       
            //filtro reposición gps
        } elseif(in_array($tipo, [15]) ) {
            $unidades->whereExists(function ($query) use($listado) {
                $query->select(DB::raw(1))
                ->from('unidad_tramite_gps_info as tt')
                ->whereColumn('tt.unidad_id', 'unidad.id');
                });                                                            
        } else {
            $unidades->whereIn($consultaResultado, $listado);
        }
        
        $unidades->orderBy('unidad.placa', 'ASC');
        $unidadesResultados = $unidades->get()->toArray();
        $titulosResultados = array_reduce($unidadesResultados, 'array_merge', []);

        //Construcción de títulos
        foreach ($titulosResultados as $indice => $campo) {
            $tituloCampo = match ($indice) {
                "numero_economico" =>  "NÚMERO ECONÓMICO",
                "no_serie" => "SERIE (VIN)",
                "placa" => "PLACAS",
                "estatus" => "ESTATUS DEL VEHÍCULO",
                "ubicacion" => "UBICACIÓN",
                "titulo_servicio" => "PROYECTO",
                "nombre_marca" => "MARCA",
                "nombre_modelo" => "MODELO",
                "unidad_year" => "AÑO",
                "color" => "COLOR",
                "vehiculo_tipo" => "TIPO DE VEHÍCULO",
                "motor" => "MOTOR",
                "transmision" => "TRANSMISIÓN",
                "fecha_ingreso" => "FECHA DE ALTA",
                "fecha_asignacion" => "FECHA DE ASIGNACIÓN",
                "kilometraje" => "KILOMETRAJE",
                "no_poliza_seguro" => "PÓLIZA",
                "factura_compra" => "FACTURA",
                "entidad" => "ENTIDAD FEDERATIVA",
                "color_engomado" => "COLOR ENGOMADO",
                "clave_vehicular" => "CLAVE VEHICULAR",
                default => null
            };

            $this->titulos[] = $tituloCampo;
        }

        return [
            "unidades" => $unidadesResultados,
            "titulos" => $this->titulos
        ];
    }

    /**
     * Convierte un listado de colores a su equivalencia numérica
     *
     * @param array $colores
     * @param array $mapa
     * @return string
     */
    private function convertirColores(array $colores, array $mapa): array {
        $numeros = [];

        foreach ($colores as $color) {
            $color = trim($color); // limpiar espacios
            if (isset($mapa[$color])) {
                $numeros[] = $mapa[$color];
            }
        }

        return $numeros;
    }


    public function registrosaseguramiento($campos, $listado, $tipo): array
    {
        //campos de salida
        foreach ($campos as $indice => $campo) {
            $campoConsulta = match ($indice) {

                "agente" => ["utg.nombre", "AGENTE"],
                "poliza" => ["unidad_tramite_aseguramiento_info.no_poliza", "NO POLIZA"],
                "inciso" => ["unidad_tramite_aseguramiento_info.inciso", "INCISO"],
                "orden_trabajo" => ["unidad_tramite_aseguramiento_info.orden_trabajo", "ORDEN DE TRABAJO"],
                "observaciones" => ["unidad_tramite_aseguramiento_info.observaciones", "OBSERVACIONES"],
                "fecha_inicial_seguro" => ["unidad_tramite_aseguramiento_info.fecha_inicial_seguro", "Inicio de vigencia"],
                "fecha_final_seguro" => ["unidad_tramite_aseguramiento_info.fecha_final_seguro", "Fin vigencia"],
                "valor_factura" => ["unidad_tramite_aseguramiento_info.valor_factura", "Valor factura"],
                "fecha_factura_eq_esp" => ["unidad_tramite_aseguramiento_info.fecha_factura_eq_esp", "Equipo especial - Fecha de factura"],
                "fecha_factura_adaptacion" => ["unidad_tramite_aseguramiento_info.fecha_factura_adaptacion", "Adaptacion - Fecha de factura"],
                "importe" => ["unidad_tramite_aseguramiento_info.importe", "Suma asegurada de unidad"],
                "valor_eq_esp" => ["unidad_tramite_aseguramiento_info.valor_eq_esp", "Valor EQ ESP. - Suma asegurada EQ ESP"],
                "valor_adaptacion" => ["unidad_tramite_aseguramiento_info.valor_adaptacion", "Valor adaptacion - Suma asegurada Adapt"],
                "nombre_archivo_poliza" => ["unidad_tramite_aseguramiento_info.nombre_archivo_poliza", "Nombre del archivo poliza"],
                "aseguradora_id" => ["ase.nombre_aseguradora", "Aseguradora"],
                "tipo_cobertura_id" => ["tc.tipo_cobertura", "Cobertura"],
                "prima_neta" => ["unidad_tramite_aseguramiento_info.prima_neta", "Prima neta"],
                "recargos" => ["unidad_tramite_aseguramiento_info.recargos", "Regargos"],
                "servicio" => ["unidad_tramite_aseguramiento_info.servicio", "Servicio"],
                default => null
            };

            if (!empty($campoConsulta)) {
                $this->consulta[] = $campoConsulta[0];
                $this->titulos[] = $campoConsulta[1];
            }
        }
        
        //campos de filtro
        $consultaResultado = match ($tipo) {
            1 => "unidad_tramite_aseguramiento_info.serie",
            // 2 => "unidad.placa",
            // 3 => "unidad.numero_economico",
            default => null
        };

        $unidades = TramiteAseguramientoInfo::select(
            $this->consulta
        )
        ->join("aseguradora_unidad as ase", "ase.id", "unidad_tramite_aseguramiento_info.aseguradora_id")
        ->join("unidad_tipo_cobertura as tc", "tc.id", "unidad_tramite_aseguramiento_info.tipo_cobertura_id")
        ->join("unidad_tramite_gestor as utg", "utg.id", "unidad_tramite_aseguramiento_info.unidad_tramite_gestor_id")
        

        ->where("unidad_tramite_aseguramiento_info.id_status_delete", 1)
        ->whereIn($consultaResultado, $listado)
        ->orderBy('unidad_tramite_aseguramiento_info.id', 'ASC')
        ->get()->toArray();

        return [
            "unidades" => $unidades,
            "titulos" => $this->titulos,
        ];
    }



}