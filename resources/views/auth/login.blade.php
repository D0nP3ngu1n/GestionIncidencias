@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="d-flex justify-content-center align-items-center px-5 px-md-3 px-sm-1 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                    <div class="card p-5 ">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <h2 class="fw-normal mb-3 pb-3">Introduce tus credenciales para acceder</h2> 

                            <div class="form-outline mb-4 col-12 col-md-12">
                                <input type="text" id="name" name="name"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus />
                                <label class="form-label" for="name">Usuario</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-outline mb-4 ol-12 col-md-12">
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror" required
                                    autocomplete="current-password" />
                                <label class="form-label" for="password">Contraseña</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="pt-1 mb-4">
                                <button class="btn  btn-outline-primary btn-lg btn-block" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 px-0 d-none d-sm-block">
                <img style="object-fit: cover; object-position: left;" class="w-100 vh-100" src={{ asset('assets/imagenes/ies-panoramica.jpg') }}>
            </div>
        </div>
    </div>
@endsection
