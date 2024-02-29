<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencia Actualizada</title>
</head>

<body>
    <h1>Incidencia Eliminada</h1>
    <p>
        Se ha eliminado la incidencia con los siguientes detalles:
    </p>
    <ul>
        <li>ID: {{ $incidencia->id }}</li>
        <li>Tipo de la incidencia: {{ $incidencia->tipo }}</li>
        <li>Estado de la incidencia: {{ $incidencia->estado }}</li>
        <li>Descripción: {{ $incidencia->descripcion }}</li>
        <li>Usuario: {{ $usuario->nombre_completo }}</li>
        <li>Fecha de creación: {{ $incidencia->fecha_creacion }}</li>
    </ul>

</body>

</html>

