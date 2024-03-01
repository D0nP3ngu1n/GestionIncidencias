<?php

namespace App\Http\Controllers;

use App\Exports\informeExport;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InformeController extends Controller
{
    public function informeResueltasPorAdmin()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.xlsx');


    }

    public function informeResueltasPorAdminCsv()
    {
        $incidenciasAdmin = Incidencia::where('estado', 'resuelta')
            ->with('responsable')
            ->get();
        //return Excel::download(new IncidenciaExport(), 'incidencias_resueltas.xlsx');
        //return Excel::download(InformeExport::resueltasPorAdministrador($incidenciasAdmin), 'informe_resueltas_admin.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function informeResueltasPorAdminPdf()
    {
        $incidenciasAdmin = Incidencia::where('estado', 'resuelta')
            ->with('responsable')
            ->get();

        //return Excel::download(InformeExport::resueltasPorAdministrador($incidenciasAdmin), 'informe_resueltas_admin.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeAbiertasPorUsuario()
    {
        $incidenciasUsuario = Incidencia::where('estado', 'abierta')
            ->with('creador')
            ->get();

        //return Excel::download(InformeExport::abiertasPorUsuario($incidenciasUsuario), 'informe_abiertas_usuario.xlsx');
    }
    public function informeAbiertasPorUsuarioCsv()
    {
        $incidenciasUsuario = Incidencia::where('estado', 'abierta')
            ->with('creador')
            ->get();

        //return Excel::download(InformeExport::abiertasPorUsuario($incidenciasUsuario), 'informe_abiertas_usuario.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function informeAbiertasPorUsuarioPdf()
    {
        $incidenciasUsuario = Incidencia::where('estado', 'abierta')
            ->with('creador')
            ->get();

        //return Excel::download(InformeExport::abiertasPorUsuario($incidenciasUsuario), 'informe_abiertas_usuario.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeEstadisticasTipos()
    {
        $incidencias = Incidencia::select('tipo', DB::raw('count(*) as total'));
        //$estadisticasTipos = InformeExport::estadisticasTipos($incidencias);

        //return Excel::download(new informeExport($estadisticasTipos), 'informe_estadisticas_tipos.xlsx');
    }

    public function informeEstadisticasTiposCsv()
    {
        $incidencias = Incidencia::select('tipo', DB::raw('count(*) as total'));
        //$estadisticasTipos = InformeExport::estadisticasTipos($incidencias);

        //return Excel::download(new informeExport($estadisticasTipos), 'informe_estadisticas_tipos.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function informeEstadisticasTiposPdf()
    {
        $incidencias = Incidencia::select('tipo', DB::raw('count(*) as total'));
        //$estadisticasTipos = InformeExport::estadisticasTipos($incidencias);

        //return Excel::download(new informeExport($estadisticasTipos), 'informe_estadisticas_tipos.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeTiempoDedicadoPorIncidencia()
    {
        $incidencias = Incidencia::all();
        //$tiempoDedicado = InformeExport::tiempoDedicadoPorIncidencia($incidencias);

        //return Excel::download(new InformeExport($tiempoDedicado), 'informe_tiempo_dedicado.xlsx');
    }

    public function informeTiempoDedicadoPorIncidenciaCsv()
    {
        $incidencias = Incidencia::all();
        //$tiempoDedicado = InformeExport::tiempoDedicadoPorIncidencia($incidencias);

        //return Excel::download(new InformeExport($tiempoDedicado), 'informe_tiempo_dedicado.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function informeTiempoDedicadoPorIncidenciaPdf()
    {
        $incidencias = Incidencia::all();
        //$tiempoDedicado = InformeExport::tiempoDedicadoPorIncidencia($incidencias);

        //return Excel::download(new InformeExport($tiempoDedicado), 'informe_tiempo_dedicado.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeTiemposResolucionPorTipo()
    {
        $incidencias = Incidencia::all();
        //$tiemposResolucion = InformeExport::tiemposResolucionPorTipo($incidencias);

        //return Excel::download(new InformeExport($tiemposResolucion), 'informe_tiempos_resolucion_por_tipo.xlsx',);
    }
    public function informeTiemposResolucionPorTipoCsv()
    {
        $incidencias = Incidencia::all();
        //$tiemposResolucion = InformeExport::tiemposResolucionPorTipo($incidencias);

        //return Excel::download(new InformeExport($tiemposResolucion), 'informe_tiempos_resolucion_por_tipo.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function informeTiemposResolucionPorTipoPdf()
    {
        $incidencias = Incidencia::all();
        // $tiemposResolucion = InformeExport::tiemposResolucionPorTipo($incidencias);

        //return Excel::download(new InformeExport($tiemposResolucion), 'informe_tiempos_resolucion_por_tipo.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function informeTiempoDedicadoEIncidenciasPorAdministrador()
    {
        $incidencias = Incidencia::all();
        //$informeCombinado = InformeExport::tiempoDedicadoEIncidenciasPorAdministrador($incidencias);

        // return Excel::download(new InformeExport($informeCombinado), 'informe_tiempo_dedicado_e_incidencias_por_admin.xlsx');
    }

    public function informeTiempoDedicadoEIncidenciasPorAdministradorCsv()
    {
        $incidencias = Incidencia::all();
        //$informeCombinado = InformeExport::tiempoDedicadoEIncidenciasPorAdministrador($incidencias);

        //return Excel::download(new InformeExport($informeCombinado), 'informe_tiempo_dedicado_e_incidencias_por_admin.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function informeTiempoDedicadoEIncidenciasPorAdministradorPdf()
    {
        $incidencias = Incidencia::all();
        //$informeCombinado = InformeExport::tiempoDedicadoEIncidenciasPorAdministrador($incidencias);

        //return Excel::download(new InformeExport($informeCombinado), 'informe_tiempo_dedicado_e_incidencias_por_admin.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
