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

    <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label for="apellido1" class="form-label">Primer Apellido:</label>
            <input type="text" id="apellido1" name="apellido1" class="form-control">
        </div>
        <div class="mb-3">
            <label for="apellido2" class="form-label">Segundo Apellido:</label>
            <input type="text" id="apellido2" name="apellido2" class="form-control">
        </div>
        <div class="mb-3">
            <label for="correo_asociado" class="form-label">Correo electrónico:</label>
            <input type="correo_asociado" id="correo" name="correo" class="form-control">
        </div>
        <div class="mb-3">
            <label for="departamento" class="form-label">Departamento:</label>
            <input type="text" id="departamento" name="departamento" class="form-control">
        </div>
        <div class="mb-3">
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
        <div id="sel1"class="mb-3 invisible">
            <label for="subtipo" class="form-label">Subtipo:</label>
            <select id="subtipo" name="subtipo" class="form-select"></select>
        </div>
        <div id="sel2"class="mb-3 invisible">
            <label for="sub_subtipo" class="form-label">Sub_subtipo</label>
            <select id="sub_subtipo" name="sub_subtipo" class="form-select"></select>
        </div>
        <script>
            window.addEventListener('load', inicio, false);
            let array = new Array();
            /**
             * Array de pruebas con los tipos y subtipos de incidencias
             */
            array['EQUIPOS'] = ['PC', 'Altavoces', 'Monitor', 'Proyector', 'Pantalla Interactiva', 'Portatil', 'Impresoras'];
            array['CUENTAS'] = ['Educantabria', 'Google Classroom', 'Dominio', 'Yedra'];
            array['WIFI'] = ['Iesmiguelherrero', 'WIECAN'];
            array['SOFTWARE'] = ['Instalacion', 'Actualizacion'];
            array['EQUIPOS']['PC'] = ['Raton', 'Ordenador', 'Teclado'];
            array['EQUIPOS']['Portatil'] = ['Portatil proporcionado por conserjeria', 'Portatil de aula'];

            /**
             * Metodo que añade los eventos a los combos pertinentes
             *
             * @param {none} no recibe nada
             * @return {none} no devuelve nada al ser un metodo void
             */
            function inicio() {
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
                    switch (opc) {
                        case "EQUIPOS":
                            var arr = array['EQUIPOS'];
                            sel.innerHTML += `<option>...</option>`;
                            for (let i = 0; i < arr.length; i++) {
                                sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                            }

                            break;
                        case "CUENTAS":
                            var arr = array['CUENTAS'];
                            for (let i = 0; i < arr.length; i++) {
                                sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;

                            }
                            break;
                        case "WIFI":
                            var arr = array['WIFI'];
                            for (let i = 0; i < arr.length; i++) {
                                sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
                            }

                            break;
                        case "SOFTWARE":
                            var arr = array['SOFTWARE'];
                            for (let i = 0; i < arr.length; i++) {
                                sel.innerHTML += `<option value="${arr[i]}">${arr[i]}</option>`;
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
                    case "Portatil":
                        document.getElementById('sel2').classList.remove('invisible');
                        var arr = array['EQUIPOS']['Portatil'];
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
        <div class="mb-3">
            <label for="numero_etiqueta" class="form-label">Etiqueta del equipo:</label>
            <input type="text" id="numero_etiqueta" name="numero_etiqueta" class="form-control">
        </div>
        <div class="mb-3">
            <label for="aula" class="form-label">Aula:</label>
            <input type="text" id="aula" name="aula" class="form-control">
        </div>
        <div class="mb-3">
            <label for="puesto" class="form-label">Puesto en el aula:</label>
            <input type="text" id="puesto" name="puesto" class="form-control">
        </div>
        <div class="form-outline">
            <label for="descripcion" class="form-label">Descripcion:</label>
            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="adjunto" class="form-label">Archivo Adjunto:</label>
            <input type="file" id="adjunto" name="adjunto" class="form-control">
        </div>
        <input type="submit" id="crear "class="btn btn-outline-primary col" value="Crear Incidencia">
    </form>
@endsection
