<style>
    th, tr, thead {
        border: 0px;
    }
</style>
<div>
    <table>
        <thead>
            <th>ID</th>
            <th>Tipo</th>
            <th>ID del Subtipo</th>
            <th>Fecha de creacion</th>
            <th>Fecha de cierre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Adjunto URL</th>
            <th>ID del Creador</th>
            <th>ID del Responsable</th>
            <th>Duracion</th>
            <th>ID del Equipo</th>
            <th>Prioridad</th>
        </thead>
        @foreach ($incidencias as $incidencia)
            <tr>
                <td>{{ $incidencia->id }}</td>
                <td>{{ $incidencia->tipo }}</td>
                <td>{{ $incidencia->subtipo_id }}</td>
                <td>{{ $incidencia->fecha_creacion }}</td>
                <td>{{ $incidencia->fecha_cierre }}</td>
                <td>{{ $incidencia->descripcion }}</td>
                <td>{{ $incidencia->estado }}</td>
                <td>{{ $incidencia->adjunto_url }}</td>
                <td>{{ $incidencia->creador_id }}</td>
                <td>{{ $incidencia->responsable_id }}</td>
                <td>{{ $incidencia->duracion }}</td>
                <td>{{ $incidencia->equipo_id }}</td>
                <td>{{ $incidencia->prioridad }}</td>
            </tr>
        @endforeach
    </table>
    <div>
        <form action="{{ route('exports.export') }}" method="POST">
            @csrf
            <button type="submit">Exportar a Excel</button>
        </form>
        <form action="{{ route('exports.pdf') }}" method="POST">
            @csrf
            <button type="submit">Exportar a PDF</button>
        </form>
        <form action="{{ route('exports.csv') }}" method="POST">
            @csrf
            <button type="submit">Exportar a CSV</button>
        </form>
    </div>
</div>
