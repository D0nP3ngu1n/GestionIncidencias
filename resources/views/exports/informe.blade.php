<div>
    <table>
        @foreach ($incidenciasAdmin as $incidenciaAdmin)
            <tr>
                <td>{{ $incidenciasAdmin->id }}</td>
                <td>{{ $incidenciasAdmin->tipo }}</td>
                <td>{{ $incidenciasAdmin->subtipo_id }}</td>
                <td>{{ $incidenciasAdmin->fecha_creacion }}</td>
                <td>{{ $incidenciasAdmin->fecha_cierre }}</td>
                <td>{{ $incidenciasAdmin->descripcion }}</td>
                <td>{{ $incidenciasAdmin->estado }}</td>
                <td>{{ $incidenciasAdmin->creador->nombre_completo }}</td>
                <td>{{ $incidenciasAdmin->responsable->nombre_completo }}</td>
                <td>{{ $incidenciasAdmin->duracion }}</td>
                <td>{{ $incidenciasAdmin->prioridad }}</td>
            </tr>
        @endforeach
    </table>
    <table>
        @foreach ($incidenciasUsuario as $incidenciaUsuario)
            <tr>
                <td>{{ $incidenciasUsuario->id }}</td>
                <td>{{ $incidenciasUsuario->tipo }}</td>
                <td>{{ $incidenciasUsuario->subtipo_id }}</td>
                <td>{{ $incidenciasUsuario->fecha_creacion }}</td>
                <td>{{ $incidenciasUsuario->fecha_cierre }}</td>
                <td>{{ $incidenciasUsuario->descripcion }}</td>
                <td>{{ $incidenciasUsuario->estado }}</td>
                <td>{{ $incidenciasUsuario->creador->nombre_completo }}</td>
                <td>{{ $incidenciasUsuario->responsable->nombre_completo }}</td>
                <td>{{ $incidenciasUsuario->duracion }}</td>
                <td>{{ $incidenciasUsuario->prioridad }}</td>
            </tr>
        @endforeach
    </table>
    <table>
        <tr>
            <th>Tipo</th>
            <th>Total</th>
        </tr>
        @foreach ($estadisticasTipos as $estadisticaTipo)
            <tr>
                <td>{{ $estadisticaTipo->tipo }}</td>
                <td>{{ $estadisticaTipo->total }}</td>
            </tr>
        @endforeach
    </table>
    <table>

        @foreach ($tiempoDedicado as $tiempo)
            <td></td>
        @endforeach
    </table>
</div>
