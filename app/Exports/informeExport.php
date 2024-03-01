<?php

namespace App\Exports;

use App\Models\Incidencia;
use Maatwebsite\Excel\Concerns\FromCollection;

class informeExport implements FromCollection
{
    protected $incidencias;

    public function __construct($incidencias)
    {
        $this->incidencias = $incidencias;
    }

    public function collection()
    {
        return $this->incidencias;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public static function resueltasPorAdministrador($incidencias)
    {
        return(new self($incidencias))
            ->collection()
            ->groupBy('responsable.nombre_completo');
    }

    public static function abiertasPorUsuario($incidencias)
    {
        return(new self($incidencias))
            ->collection()
            ->groupBy('creador.nombre_completo');
    }

    public static function estadisticasTipos($incidencias)
    {

        return(new self($incidencias))
            ->collection()
            ->groupBy('tipo');  // Ajusta esto según tu lógica específica
    }

    public static function tiempoDedicadoPorIncidencia($incidencias)
    {
        return $incidencias->filter(function ($incidencia) {
            return !is_null($incidencia->duracion);
        })
            ->map(function ($incidencia) {
                return [
                    'ID Incidencia' => $incidencia->id,
                    'Descripción' => $incidencia->descripcion,
                    'Tiempo dedicado' => $incidencia->duracion,
                ];
            });
    }

    public static function tiemposResolucionPorTipo($incidencias)
    {
        return $incidencias->filter(function ($incidencia) {
            return $incidencia->estado === 'resuelta' && !is_null($incidencia->duracion);
        })
            ->groupBy('tipo')
            ->map(function ($incidenciasPorTipo) {
                $tiempoPromedio = $incidenciasPorTipo->avg('duracion');

                return [
                    'Tipo de Incidencia' => $incidenciasPorTipo->first()->tipo,
                    'Tiempo Promedio de Resolución' => $tiempoPromedio,
                ];
            });
    }

    public static function tiempoDedicadoEIncidenciasPorAdministrador($incidencias)
    {
        $tiempoDedicado = $incidencias->filter(function ($incidencia) {
            return $incidencia->estado === 'resuelta' && !is_null($incidencia->duracion);
        })
            ->groupBy('responsable.nombre_completo')
            ->map(function ($incidenciasPorAdmin) {
                $tiempoTotal = $incidenciasPorAdmin->sum('duracion');

                return [
                    'Administrador' => $incidenciasPorAdmin->first()->responsable->nombre_completo,
                    'Tiempo Total Dedicado' => $tiempoTotal,
                    'Incidencias' => $incidenciasPorAdmin,
                ];
            });

        return $tiempoDedicado;
    }
}