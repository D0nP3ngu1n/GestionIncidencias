@extends('layouts.app')

@section('content')
    <div class="vh-100" style="background-color: rgb(65, 105, 225);">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src={{asset('assets/imagenes/ies-panoramica.jpg')}} alt="login form" class="img-fluid img-login mx-4 my-4"/> <!-- Poner foto de un ordenador, logo instituto? -->
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <span class="h1 fw-bold mb-0">Login</span>
                                        </div>
                                        <h5 class="fw-normal mb-3 pb-3">Inicia sesión con tus datos de dominio</h5>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Usuario</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Contraseña</label>
                                            <input type="password" id="password" class="form-control form-control-lg" />
                                        </div>
                                        <div class="form-outline mb-4 form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">Recuérdame</label>
                                        </div>
                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="button">Login</button>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a class="small text-muted" href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
