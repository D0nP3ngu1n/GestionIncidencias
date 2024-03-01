<div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Duracion</th>
                <th>Creador</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estadisticas as $estadistica)
                <tr>
                    <td>{{ $estadistica->id }}</td>
                    <td>{{ $estadistica->tipo }}</td>
                    <td>{{ $estadistica->duracion }}</td>
                    <td>{{ $estadistica->creador->nombre_completo }}</td>
                    @if ($estadistica->responsable && $estadistica->responsable->nombre_completo)
                        <td>{{ $estadistica->responsable->nombre_completo }}</td>
                    @else
                        <td>No asignado</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
