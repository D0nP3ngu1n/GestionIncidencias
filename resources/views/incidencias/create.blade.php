@extends('layouts.plantilla')
@section('titulo', 'Nueva Incidencia')
@section('contenido')
    <h1>Nueva incidencia</h1>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Hubo errores en el formulario:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="caja-formulario" class="container">
        <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="form-horizantal">
            @csrf
            <input type="text" id="user_id" name="user_id" value="{{ $user = auth()->user()->id }}">
            <div class="col-sm-12">
                <label for="nombre" class="form-label">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="{{ $user = auth()->user()->nombre_completo }}" readonly>
            </div>
            <div class="row">
                @if ($user = auth()->user()->email)
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label for="correo_asociado" class="form-label col-sm-4">Correo electrónico:</label>
                            <div class="col-sm-12">
                                <input type="correo_asociado" id="correo_asociado" name="correo_asociado"
                                    class="form-control" value={{ $user = auth()->user()->email }} disabled>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <label for="correo_asociado" class="form-label col-sm-4">Correo electrónico:</label>
                            <div class="col-sm-12">
                                <input type="correo_asociado" id="correo_asociado" name="correo_asociado"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="departamento" class="form-label col-sm-4">Departamento:</label>
                        <div class="col-sm-12">
                            <input type="text" id="departamento" name="departamento" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="" class="form-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-select">
                        <option selected value>...</option>
                        <option value="EQUIPOS">Equipos</option>
                        <option value="CUENTAS">Cuentas</option>
                        <option value="WIFI">Wifi</option>
                        <option value="SOFTWARE">Software</option>
                        <option value="INTERNET">Internet</option>
                    </select>
                </div>
                <div id="sel1"class="col-sm-4 invisible">
                    <label for="subtipo" class="form-label">Subtipo:</label>
                    <select id="subtipo" name="subtipo" class="form-select"></select>
                </div>
                <div id="sel2"class="col-sm-4 invisible">
                    <label for="sub_subtipo" class="form-label">Sub_subtipo</label>
                    <select id="sub_subtipo" name="sub_subtipo" class="form-select"></select>
                </div>
            </div>
            <script>
                window.addEventListener('load', inicio, false);
                let array = new Array();
                /**
                 * Array de pruebas con los tipos y subtipos de incidencias
                 */
                array['EQUIPOS'] = ['PC', 'ALTAVOCES', 'MONITOR', 'PROYECTOR', 'PANTALLA', 'PORTATIL', 'IMPRESORAS'];
                array['CUENTAS'] = ['EDUCANTABRIA', 'GOOGLE CLASSROOM', 'DOMINIO', 'YEDRA'];
                array['WIFI'] = ['Iesmiguelherrero', 'WIECAN'];
                array['SOFTWARE'] = ['INSTALACION', 'ACTUALIZACION'];
                array['EQUIPOS']['PC'] = ['RATON', 'ORDENADOR', 'TECLADO'];
                array['EQUIPOS']['PORTATIL'] = ['PROPORCIONADO POR CONSERJERIA', 'DE AULA'];

                /**
                 * Metodo que añade los eventos a los combos pertinentes
                 *
                 * @param {none} no recibe nada
                 * @return {none} no devuelve nada al ser un metodo void
                 */
                function inicio() {
                    console.log(document.getElementById('nombre').value);
                    document.getElementById('tipo').addEventListener('change', rellenar1, false);
                    document.getElementById('subtipo').addEventListener('change', rellenar2, false);
                }

                /**
                 * Metodo que rellena el segundo select segun los datos del array de subtipos
                 *
                 * @param {none} no recibe nada
                 * @return {none} no devuelve nada al ser un metodo void
                 */
                function rellenar1() {
                    let opc = document.getElementById('tipo').value;
                    console.log(opc);
                    let sel = document.getElementById('subtipo');
                    sel.innerHTML = '';
                    //solo actualizará los datos si la opción es distinta a INTERNET
                    if (opc !== "INTERNET") {
                        document.getElementById('sel1').classList.remove('invisible');
                        sel.innerHTML += `<option selected>...</option>`;
                        switch (opc) {
                            case "EQUIPOS":
                                var arr = array['EQUIPOS'];
                                for (let i = 0; i < arr.length; i++) {
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    //Con esta linea hago que la caja de informacion del equipo sea visible
                                    document.getElementById('info-equipo').classList.remove('invisible');
                                }

                                break;
                            case "CUENTAS":
                                var arr = array['CUENTAS'];
                                for (let i = 0; i < arr.length; i++) {
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    document.getElementById('info-equipo').classList.add('invisible');
                                }
                                break;
                            case "WIFI":
                                var arr = array['WIFI'];
                                for (let i = 0; i < arr.length; i++) {
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    document.getElementById('info-equipo').classList.add('invisible');
                                }

                                break;
                            case "SOFTWARE":
                                var arr = array['SOFTWARE'];
                                for (let i = 0; i < arr.length; i++) {
                                    sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                                    document.getElementById('info-equipo').classList.add('invisible');
                                }

                                break;
                            default:
                                document.getElementById('sel1').classList.add('invisible');
                                document.getElementById('sel2').classList.add('invisible');
                                break;
                        }
                    } else {
                        //hace invisibles los otros dos selects si se vueleve a una opcion que no los necesite
                        document.getElementById('sel1').classList.add('invisible');
                        document.getElementById('sel2').classList.add('invisible');
                    }

                }

                /**
                 * Metodo que rellena el tercer select con los datos del array de sub-subtipos
                 *
                 * @param {none} no recibe nada
                 * @return {none} no devuelve nada al ser un metodo void
                 */
                function rellenar2() {
                    let opc = document.getElementById('subtipo').value;
                    console.log(opc);
                    let selec = document.getElementById('sub_subtipo');
                    selec.innerHTML = '';
                    switch (opc) {
                        case opc = "PC":
                            document.getElementById('sel2').classList.remove('invisible');
                            var arr = array['EQUIPOS']['PC'];
                            for (let i = 0; i < arr.length; i++) {
                                selec.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                            }

                            break;
                        case "PORTATIL":
                            document.getElementById('sel2').classList.remove('invisible');
                            var arr = array['EQUIPOS']['PORTATIL'];
                            for (let i = 0; i < arr.length; i++) {
                                selec.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                            }
                            break;
                        default:
                            //hace invisible el select si no es necesario para la opción
                            document.getElementById('sel2').classList.add('invisible');
                            break;
                    }
                }
            </script>
            <div class="form-outline col-sm-12">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="adjunto" class="form-label col-sm-4">Archivo Adjunto:</label>
                        <div class="col-sm-12">
                            <input type="file" id="adjunto" name="adjunto" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row invisible" id="info-equipo">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="aula" class="form-label col-sm-4">Aula:</label>
                        <div class="col-sm-12">
                            <input type="text" id="aula" name="aula" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="puesto" class="form-label col-sm-4">Puesto en el aula:</label>
                        <div class="col-sm-12">
                            <input type="text" id="puesto" name="puesto" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="numero_etiqueta " class="form-label col-sm-4">Etiqueta del equipo:</label>
                        <div class="col-sm-12">
                            <input type="text" id="numero_etiqueta" name="numero_etiqueta" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <input type="submit" id="crear "class="btn btn-outline-primary col-sm-2" value="Crear Incidencia">
            </div>
        </form>
    </div>
@endsection
