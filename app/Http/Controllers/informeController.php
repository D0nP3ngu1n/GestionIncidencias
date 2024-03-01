<?php

namespace App\Http\Controllers;

use App\Exports\EstadisticasEstadoExport;
use App\Exports\InformeAbiertasExport;
use App\Exports\informeExport;
use App\Exports\ListaAdminExport;
use App\Exports\ListadasAdmin;
use App\Exports\TiempoDedicadoExport;
use App\Exports\TiempoResolucionPorTipoExport;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class InformeController extends Controller
{
    public function informeResueltasPorAdmin()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.xlsx');
    }

    public function informeResueltasPorAdminCsv()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function informeResueltasPorAdminPdf()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeAbiertasPorUsuario(Request $request)
    {
        $filtros = [
            'descripcion' => $request->filled('descripcion'),
            'tipo' => $request->filled('tipo'),
            'estado' => $request->filled('estado'),
            'creador' => $request->filled('creador'),
            'prioridad' => $request->filled('prioridad'),
            'aula' => $request->filled('aula'),
            'desde' => $request->filled('desde'),
            'hasta' => $request->filled('hasta'),
            // Agrega más filtros según sea necesario
        ];
        return Excel::download(new InformeAbiertasExport($filtros), 'informe_abiertas_usuario.xlsx');
    }
    public function informeAbiertasPorUsuarioCsv(Request $request)
    {
        $filtros = [
            'descripcion' => $request->filled('descripcion'),
            'tipo' => $request->filled('tipo'),
            'estado' => $request->filled('estado'),
            'creador' => $request->filled('creador'),
            'prioridad' => $request->filled('prioridad'),
            'aula' => $request->filled('aula'),
            'desde' => $request->filled('desde'),
            'hasta' => $request->filled('hasta'),
            // Agrega más filtros según sea necesario
        ];
        return Excel::download(new InformeAbiertasExport($filtros), 'informe_abiertas_usuario.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function informeAbiertasPorUsuarioPdf(Request $request)
    {
        $filtros = [
            'descripcion' => $request->filled('descripcion'),
            'tipo' => $request->filled('tipo'),
            'estado' => $request->filled('estado'),
            'creador' => $request->filled('creador'),
            'prioridad' => $request->filled('prioridad'),
            'aula' => $request->filled('aula'),
            'desde' => $request->filled('desde'),
            'hasta' => $request->filled('hasta'),
        ];
        return Excel::download(new InformeAbiertasExport($filtros), 'informe_abiertas_usuario.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeEstadisticasTipos()
    {

        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.xlsx');
    }

    public function informeEstadisticasTiposCsv()
    {
        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function informeEstadisticasTiposPdf()
    {
        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeTiempoDedicadoPorIncidencia()
    {
        return Excel::download(new TiempoDedicadoExport(), 'informe_tiempo_dedicado.xlsx');
    }

    public function informeTiempoDedicadoPorIncidenciaCsv()
    {
        return Excel::download(new TiempoDedicadoExport(), 'informe_tiempo_dedicado.csv',\Maatwebsite\Excel\Excel::CSV);
    }

    public function informeTiempoDedicadoPorIncidenciaPdf()
    {
        return Excel::download(new TiempoDedicadoExport(), 'informe_tiempo_dedicado.pdf',\Maatwebsite\Excel\Excel::DOMPDF);
        }

    public function informeTiemposResolucionPorTipo()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.xslx');
     }
    public function informeTiemposResolucionPorTipoCsv()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.csv',\Maatwebsite\Excel\Excel::CSV);
    }
    public function informeTiemposResolucionPorTipoPdf()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.pdf',\Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeTiempoDedicadoEIncidenciasPorAdministrador()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.xslx',);
    }

    public function informeTiempoDedicadoEIncidenciasPorAdministradorCsv()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.csv',\Maatwebsite\Excel\Excel::CSV);
    }

    public function informeTiempoDedicadoEIncidenciasPorAdministradorPdf()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.pdf',\Maatwebsite\Excel\Excel::DOMPDF);
    }
}
