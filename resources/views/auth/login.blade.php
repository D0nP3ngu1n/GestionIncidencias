@extends('layouts.app')

@section('content')
<section class="vh-100 bg-success">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="{{asset('storage/imagenes/IES_MIGUEL_HERRERO_PEREDA.jpg') }}" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                        <span class="h1 fw-bold mb-0">Gestión de incidencias</span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Inicio de sesión</h5>

                                    <div class="form-outline mb-4">
                                        <input type="text" id="name" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus />
                                        <label class="form-label" for="name">Usuario</label>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required autocomplete="current-password" />
                                        <label class="form-label" for="password">Contraseña</label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
