<nav class="navbar navbar-expand-md bg-gradient-primary p-3 d-flex flex-column align-content-start" id="sidebar">
    <div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

                 <!-- Nav Item - Informes -->
                 <li class="nav-item">
                    <a class="nav-link texto-nav d-flex" href="{{ route('exports.index') }}">
                        <i class="bi bi-speedometer2 px-1"></i>
                        <span>Informes</span>
                    </a>
                </li>

                <!-- Nav Item - Gestion Usuario -->
                @hasrole('Administrador')
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
