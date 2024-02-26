<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<header class="navbar navbar-expand navbar-light bg-white shadow ml-auto d-flex justify-content-between">
    <div class="mx-5">
        <img class="img-logo" src={{asset('assets/imagenes/ies-mini.jpg')}}>
    </div>
    <div class="dropdown mx-5">
        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="mr-2 small">Douglas McGee</span>
            <img class="img-profile rounded-circle" src={{asset('assets/imagenes/perfil_01.jpg')}}>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li>
                <a class="dropdown-item" href="#">
                <i class="bi bi-person-fill"></i>
                    Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</header>