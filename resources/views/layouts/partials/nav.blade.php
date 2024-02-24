<nav>
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Secciones
    </div>

    <!-- Nav Item - Listado de Incidencias -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.index') }}">
        <i class="bi bi-list-ul"></i>
        <span class="hola">Listado Incidencias</span></a>
    </li>

    <!-- Nav Item - Gestion Usuario -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.create') }}">
        <i class="bi bi-person-lines-fill"></i>
        <span>Gestión Usuario</span>
      </a>
    </li>

    <!-- Nav Item - Informes -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.create') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Infrormes</span>
      </a>
    </li>

    <!-- Nav Item - Informes -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.create') }}">
        <i class="bi bi-speedometer2"></i>
        <span>TEST</span>
      </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider"> <!-- d-md-block adaptacion tamaño -->

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center"> <!-- d-md-inline adaptacion tamaño -->
      <button class="rounded-circle border-0" id="sidebarToggle"><</button>
    </div>
  </ul>
</nav>