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
    /**
     * Genera un informe en formato Excel con las incidencias resueltas, agrupadas por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeResueltasPorAdmin()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.xlsx');
    }

    /**
     * Genera un informe en formato CSV con las incidencias resueltas, agrupadas por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeResueltasPorAdminCsv()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con las incidencias resueltas, agrupadas por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeResueltasPorAdminPdf()
    {
        return Excel::download(new informeExport(), 'incidencias_resueltas.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con las incidencias abiertas por cada usuario.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeAbiertasPorUsuario()
    {
        return Excel::download(new InformeAbiertasExport(), 'informe_abiertas_usuario.xlsx');
    }

    /**
     * Genera un informe en formato CSV con las incidencias abiertas por cada usuario.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeAbiertasPorUsuarioCsv(Request $request)
    {
        return Excel::download(new InformeAbiertasExport(), 'informe_abiertas_usuario.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con las incidencias abiertas por cada usuario.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeAbiertasPorUsuarioPdf()
    {

        return Excel::download(new InformeAbiertasExport(), 'informe_abiertas_usuario.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con estadísticas sobre los tipos de incidencias.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeEstadisticasTipos()
    {

        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.xlsx');
    }

    /**
     * Genera un informe en formato CSV con estadísticas sobre los tipos de incidencias.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeEstadisticasTiposCsv()
    {
        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con estadísticas sobre los tipos de incidencias.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeEstadisticasTiposPdf()
    {
        return Excel::download(new EstadisticasEstadoExport(), 'informe_estadisticas_tipos.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con el tiempo dedicado a cada incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeTiempoDedicadoPorIncidencia()
    {
        return Excel::download(new TiempoDedicadoExport(), 'informe_tiempo_dedicado.xlsx');
    }


    /**
     * Genera un informe en formato CSV con el tiempo dedicado a cada incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function informeTiempoDedicadoPorIncidenciaCsv()
    {
        return Excel::download(new TiempoDedicadoExport(), 'informe_tiempo_dedicado.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con el tiempo dedicado a cada incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    /**
     * Genera un informe en formato Excel con los tiempos de resolución por tipo de incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiemposResolucionPorTipo()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.xlsx');
    }

    /**
     * Genera un informe en formato CSV con los tiempos de resolución por tipo de incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiemposResolucionPorTipoCsv()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con los tiempos de resolución por tipo de incidencia.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiemposResolucionPorTipoPdf()
    {
        return Excel::download(new TiempoResolucionPorTipoExport(), 'informe_resolucion_tipo.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    /**
     * Genera un informe en formato Excel con el tiempo dedicado a cada incidencia por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiempoDedicadoEIncidenciasPorAdministrador()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.xlsx');
    }

    /**
     * Genera un informe en formato CSV con el tiempo dedicado a cada incidencia por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiempoDedicadoEIncidenciasPorAdministradorCsv()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Genera un informe en formato PDF con el tiempo dedicado a cada incidencia por administrador.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function informeTiempoDedicadoEIncidenciasPorAdministradorPdf()
    {
        return Excel::download(new ListaAdminExport(), 'informe_tiempo_dedicado_e_incidencias_por_admin.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}