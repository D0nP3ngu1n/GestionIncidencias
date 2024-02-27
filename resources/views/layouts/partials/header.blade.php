<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

<header class="navbar navbar-expand navbar-light bg-white shadow ml-auto d-flex justify-content-between">
    <div class="mx-5">
        <img class="img-logo" src={{ asset('assets/imagenes/ies-mini.jpg') }}>
    </div>
    <div class="dropdown mx-5">
        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
            data-bs-toggle="dropdown" aria-expanded="false">
            <span class="mr-2 small">{{ auth()->user()->nombre }}</span>
            <img class="img-profile rounded-circle" src={{ asset('assets/imagenes/perfil_01.jpg') }}>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            @if (Auth::check())
                <li>
                    <a class="dropdown-item" href="{{route('usuarios.show',auth()->user())}}">
                        <i class="bi bi-person-fill"></i>
                        Profile
                    </a>
                </li>
                <li>

                    <span class="text-white mb-1 lg:mr-4 lg:mb-0">{{ auth()->user()->nombre }}</span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <i class="bi bi-box-arrow-right"></i>

                        <input type="submit" value="Logout">
                    </form>

                </li>
            @endif
        </ul>
    </div>
</header>
