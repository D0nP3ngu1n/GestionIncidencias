@extends('layouts.plantilla')
@section('titulo', 'Dashboard')
@section('contenido')

    <div class="border-1 rounded-4 p-2 d-flex ">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por tipo:
            <canvas id="tipoChart" width="100" height="100"></canvas>
        </div>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por prioridad:
            <canvas id="prioridadChart" width="100" height="100"></canvas>
        </div>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por estado:
            <canvas id="estadoChart" width="100" height="100"></canvas>
        </div>
        <div class="p-3 w-25 h-25 m-1 rounded-4 bg-colorSecundario">
            Incidencias por Administrador:
            <canvas id="responsableChart" width="100" height="100"></canvas>
        </div>
        @push('script')

        <script>
            var jsonData = @json($incidencias);
            console.log(jsonData);

            document.addEventListener("DOMContentLoaded", function() {


                // Función para contar incidencias por tipo
                function contarIncidenciasPorTipo(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.tipo] = (counts[item.tipo] || 0) + 1;
                    });
                    return counts;
                }

                // Función para contar incidencias por prioridad
                function contarIncidenciasPorPrioridad(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.prioridad] = (counts[item.prioridad] || 0) + 1;
                    });
                    return counts;
                }

                // Función para contar incidencias por estado
                function contarIncidenciasPorEstado(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.estado] = (counts[item.estado] || 0) + 1;
                    });
                    return counts;
                }

                function contarIncidenciasPorResponsable(data) {
                    var counts = {};
                    data.forEach(function(item) {
                        counts[item.responsable_id] = (counts[item.responsable_id] || 0) + 1;
                    });
                    return counts;
                }

                // Obtener los recuentos
                var incidenciasPorTipo = contarIncidenciasPorTipo(jsonData);
                var incidenciasPorPrioridad = contarIncidenciasPorPrioridad(jsonData);
                var incidenciasPorEstado = contarIncidenciasPorEstado(jsonData);
                var incidenciasPorResponsable = contarIncidenciasPorResponsable(jsonData);

                // Configurar los gráficos
                var tipoCtx = document.getElementById('tipoChart').getContext('2d');
                var tipoChart = new Chart(tipoCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(incidenciasPorTipo),
                        datasets: [{
                            label: 'Incidencias por Tipo',
                            data: Object.values(incidenciasPorTipo),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });

                var prioridadCtx = document.getElementById('prioridadChart').getContext('2d');
                var prioridadChart = new Chart(prioridadCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(incidenciasPorPrioridad),
                        datasets: [{
                            label: 'Incidencias por Prioridad',
                            data: Object.values(incidenciasPorPrioridad),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });

                var estadoCtx = document.getElementById('estadoChart').getContext('2d');
                var estadoChart = new Chart(estadoCtx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(incidenciasPorEstado),
                        datasets: [{
                            label: 'Incidencias por Estado',
                            data: Object.values(incidenciasPorEstado),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });

                // Configurar los datos para el gráfico
    var responsables = Object.keys(incidenciasPorResponsable);
    var incidenciasPorResponsableData = Object.values(incidenciasPorResponsable);

    // Configurar el gráfico con Chart.js
    var responsableCtx = document.getElementById('responsableChart').getContext('2d');
    var responsableChart = new Chart(responsableCtx, {
        type: 'bar',
        data: {
            labels: responsables,
            datasets: [{
                label: 'Incidencias por Responsable',
                data: incidenciasPorResponsableData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
            });
        </script>
        @endpush
    </div>
@endsection
