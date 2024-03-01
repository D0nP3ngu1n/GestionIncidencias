<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;

class InformeAbiertasExport implements FromView
{
    protected $filtros;

    public function __construct($filtros)
    {
        $this->filtros = $filtros;
    }

    public function view(): View
    {
        $incidencias = Incidencia::where('estado', 'abierta')
            ->whereNotNull('creador_id')
            ->orderBy('creador_id')->get();
        return view('exports.resueltas', ['incidencias' => $incidencias]);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    protected function aplicarFiltros($query)
    {
        if (!empty($this->filtros['descripcion'])) {
            $query->where('descripcion', 'like', '%' . $this->filtros['descripcion'] . '%');
        }

        if (!empty($this->filtros['tipo'])) {
            $query->where('tipo', 'like', '%' . $this->filtros['tipo'] . '%');
        }

        if (!empty($this->filtros['estado'])) {
            $query->where('estado', $this->filtros['estado']);
        }

        if (!empty($this->filtros['creador'])) {
            $query->whereHas('creador', function ($q) {
                $q->where('nombre_completo', 'like', '%' . $this->filtros['creador'] . '%');
            });
        }

        if (!empty($this->filtros['prioridad'])) {
            $query->where('prioridad', $this->filtros['prioridad']);
        }

        if (!empty($this->filtros['aula'])) {
            $query->whereHas('equipo.aula', function ($q) {
                $q->where('codigo', $this->filtros['aula']);
            });
        }

        if (!empty($this->filtros['desde']) && !empty($this->filtros['hasta'])) {
            $desde = date($this->filtros['desde']);
            $hasta = date($this->filtros['hasta']);

            $query->whereBetween('fecha_creacion', [$desde, $hasta]);
        }

        // Agrega más condiciones según sea necesario

        return $query->get();
    }
}
