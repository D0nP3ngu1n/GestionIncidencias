{{-- <nav class="navbar navbar-expand-lg  bg-body-tertiary bg-dark">
      <a class="navbar-brand" href="#">Incidencias</a>

      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('incidencias.index') }}" class="title">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('incidencias.create') }}">Nueva incidencia</a>
        </ul>

      </div>
  </nav> --}}
  <div class="d-flex flex-column align-items-center align-items-sm-start p-5 text-white min-vh-100 bg-dark">
    <a href="/" class="d-flex align-items-center pb-3 text-white text-decoration-none">
        <span class="fs-5 d-none d-sm-inline">Equipo 3</span>
    </a>
    <ul class="nav nav-pills flex-column align-items-center align-items-sm-start" id="menu">
        <li class="nav-item">
            <a href="" class="nav-link align-middle px-0">
                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Listado de incidencias</span>
            </a>
        </li>
        <li>
            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-speedometer2"></i> <span class="d-none d-sm-inline">Informes</span> </a>
        </li>
        <li>
            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-pc-display"></i> <span class="d-none d-sm-inline">Equipos</span> </a>
        </li>
        <li>
            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fs-4 bi-people"></i> <span class="d-none d-sm-inline">Gestion de</span> </a>
        </li>
    </ul>
</div>
