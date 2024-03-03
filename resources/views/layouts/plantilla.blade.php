<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>@yield('titulo')</title>
    @vite('resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/_nav.scss')
    @vite('resources/css/navbar.css')
</head>

<body class="bg-colorPrincipal">
    @include('layouts.partials.header')

    <main class="row g-0">
        <div class="col-2">
            @include('layouts.partials.nav')
        </div>
        <div class="col-10 p-5">
            @yield('contenido')
        </div>
    </main>
    @include('layouts.partials.footer')

</body>

</html>
