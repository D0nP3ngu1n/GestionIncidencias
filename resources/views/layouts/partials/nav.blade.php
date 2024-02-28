<nav class="navbar navbar-expand-md bg-gradient-primary p-3" id="sidebar">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex flex-column justify-content-start">
                <!-- Nav Item - Listado de Incidencias -->
                <li class="nav-item">
                    <a class="nav-link texto-nav" href="{{ route('incidencias.index') }}">
                        <i class="fs-4 bi bi-list-ul"></i>
                        <span class="fs-5">Listado Incidencias</span>
                    </a>
                </li>
                <!-- Nav Item - Gestion Usuario -->
                <li class="nav-item">
                    <a class="nav-link texto-nav" href="{{ route('incidencias.create') }}">
                        <i class="fs-4 bi bi-person-lines-fill"></i>
                        <span class="fs-5">Gestión Usuario</span>
                    </a>
                </li>
                <!-- Nav Item - Informes -->
                <li class="nav-item">
                    <a class="nav-link texto-nav" href="{{ route('incidencias.create') }}">
                        <i class="fs-4 bi bi-speedometer2"></i>
                        <span class="fs-5">Informes</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
