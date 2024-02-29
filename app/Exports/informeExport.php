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
         return (new self($incidencias))
             ->collection()
             ->groupBy('responsable.nombre_completo');
     }

     public static function abiertasPorUsuario($incidencias)
     {
         return (new self($incidencias))
             ->collection()
             ->groupBy('creador.nombre_completo');
     }

     public static function estadisticasTipos($incidencias)
    {

        return (new self($incidencias))
            ->collection()
            ->groupBy('tipo');  // Ajusta esto según tu lógica específica
    }
}
