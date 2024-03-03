<nav class="navbar navbar-expand-md bg-gradient-primary p-3 d-flex flex-column align-content-start" id="sidebar">
    <div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex flex-column g-2">
                <!-- Nav Item - Listado de Incidencias -->
                <li class="nav-item">
                    <a class="nav-link texto-nav d-flex" href="{{ route('incidencias.index') }}">
                        <i class="bi bi-list-ul px-1"></i>
                        <span>Listado Incidencias</span>
                    </a>
                </li>
                @hasrole('Administrador')
                    <!-- Nav Item - Informes -->
                    <li class="nav-item dropdown bg-gradient-primary">
                        <a class="nav-link dropdown-toggle texto-nav d-flex" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-speedometer2 px-1"></i>
                            <span>Informes</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap">
                                    Informe resueltas por admin
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.resueltas.admin.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>

                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap">
                                    Informe Abiertas por Usuario
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.abiertas.usuario.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Informe Estadisticas tipos
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.estadisticas.tipos.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Tiempo Dedicado por Incidencia
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    Informe Tiempos Resolución por Tipo
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempos.resolucion.tipo.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex flex-column align-items-center">
                                <div class="mb-2 text-nowrap px-2">
                                    Informe Tiempo Dedicado e Incidencias por Admin
                                </div>
                                <div class="d-flex">
                                    <a class="dropdown-item btn btn-outline-primary btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin') }}">
                                        <i class="bi bi-filetype-xlsx fs-4 text-primary"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-success btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin.Csv') }}">
                                        <i class="bi bi-filetype-csv fs-4 text-success"></i>
                                    </a>
                                    <a class="dropdown-item btn btn-outline-danger btn-sm mx-1"
                                        href="{{ route('export.informe.tiempo.dedicado.e.incidencias.admin.Pdf') }}">
                                        <i class="bi bi-filetype-pdf fs-4 text-danger"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- Nav Item - Gestion Usuario -->
                    <li class="nav-item">
                        <a class="nav-link texto-nav d-flex" href="{{ route('usuarios.index') }}">
                            <i class="bi bi-person-lines-fill px-1"></i>
                            <span>Gestión Usuario</span>
                        </a>
                    </li>
                @endhasrole
                 <!-- Nav Item - Dashboard -->
                 <li class="nav-item">
                    <a class="nav-link texto-nav d-flex" href="{{ route('dashboard.index') }}">
                        <i class="bi bi-speedometer px-1"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
