@extends('layouts.plantilla')
@section('titulo', 'Listar Incidencias')
@section('contenido')
    <h1 class="text-2xl font-bold mx-8">Listado de incidencias</h1>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{ session('error') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Confirmacion:</strong> {{ session('success') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @forelse ($incidencias as $incidencia)
    @empty
        <p>No existen Incidencias</p>
    @endforelse
    <div class="d-flex flex-row gap-3 flex-wrap justify-content-center">

        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>ordenador sala IF04 roto</span>
                    </h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">Cerrada</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>WIFI Pasillo superior sin
                            conexion</span></h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">Pendiente</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>ordenador sala IF04 roto</span>
                    </h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">En curso</span></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>ordenador sala IF04 roto</span>
                    </h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">Cerrada</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>WIFI Pasillo superior sin
                            conexion</span></h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">Pendiente</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>ordenador sala IF04 roto</span>
                    </h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">En curso</span></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>ordenador sala IF04 roto</span>
                    </h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">Cerrada</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>WIFI Pasillo superior sin
                            conexion</span></h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">Pendiente</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Nº #1</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>ordenador sala IF04 roto</span>
                    </h2>
                    <p class="m-b-0">Tipo : Equipo<span class="f-right">Pantalla</span></p>
                    <p class="m-b-0">Aula:<span class="f-right">If:04</span></p>
                    <p class="m-b-0">Creado por: <span class="f-right">Carmen Iza</span></p>
                    <p class="m-b-0">Responsable:<span class="f-right">Luis</span></p>
                    <p class="m-b-0">Estado<span class="f-right">En curso</span></p>
                </div>
            </div>
        </div>
    </div>
@endsection
