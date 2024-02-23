<nav>
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <!-- 
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>
    -->
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
        <i class="fa-regular fa-rectangle-list"></i>
        <span>Listado Incidencias</span></a>
    </li>

    <!-- Nav Item - Nueva Incidencia -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('incidencias.create') }}">
        <i class="fa-solid fa-circle-plus"></i>
        <span>Nueva Incidencia</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block"> <!-- d-md-block adaptacion tamaño -->

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline"> <!-- d-md-inline adaptacion tamaño -->
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



    <!--    
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Incidencias</a>

        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('incidencias.index') }}" class="title">Inicio</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('incidencias.create') }}">Nueva incidencia</a>
              </li>	
          </ul>

        </div>
      </div>
  -->
  </ul>
</nav>