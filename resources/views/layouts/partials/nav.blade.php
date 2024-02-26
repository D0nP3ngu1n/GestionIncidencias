<nav>
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion rounded-3 mx-4 my-1 px-3" id="accordionSidebar">
    <!-- Sidebar - Brand -->

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <h1>Equipo 3</h1>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Divider -->
    <hr class="sidebar-divider ">

    <!-- Heading -->
    <div class="sidebar-heading text-white">
      Secciones
    </div>

    <!-- Nav Item - Listado de Incidencias -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.index') }}">
        <i class="fs-4 bi bi-list-ul"></i>
        <span class="fs-4">Listado Incidencias</span>
        </a>
    </li>

    <!-- Nav Item - Gestion Usuario -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.create') }}">
        <i class=" fs-4 bi bi-person-lines-fill"></i>
        <span class="fs-4" >Gestión Usuario</span>
      </a>
    </li>

    <!-- Nav Item - Informes -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.create') }}">
        <i class="fs-4 bi bi-speedometer2"></i>
        <span class="fs-4">Infrormes</span>
      </a>
    </li>

    <!-- Nav Item - Informes -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.create') }}">
        <i class="fs-4 bi bi-speedometer2"></i>
        <span class="fs-4">TEST</span>
      </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider"> <!-- d-md-block adaptacion tamaño -->

  </ul>
</nav>
