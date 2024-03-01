<div>

    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estadisticas as $estadistica)
                <tr>
                    <td>{{ $estadistica->tipo }}</td>
                    <td>{{ $estadistica->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
