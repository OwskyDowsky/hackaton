@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">✏️ Editar Historia</h1>

    <form method="POST" action="{{ route('cuentacuentos.update', $historia->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label fw-bold">Nombre de la Historia:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $historia->nombre) }}" class="form-control" required>
        </div>

        <hr class="my-4">

        {{-- Edición de escenas --}}
        @php
            $jsonPath = base_path('python_scripts/' . $historia->archivo_json);
            $escenas = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];
        @endphp

        <div id="escenas-container">
            @foreach($escenas as $escenaId => $escena)
                <div class="card p-4 mb-4 escena-block">
                    <h5>🎬 Escena: <input type="text" name="escenas[{{ $escenaId }}][nombre]" value="{{ $escenaId }}" class="form-control" required></h5>

                    <div class="mb-3">
                        <label class="fw-bold">Texto:</label>
                        <textarea name="escenas[{{ $escenaId }}][texto]" rows="3" class="form-control" required>{{ $escena['texto'] }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Audio actual:</label>
                        @if($escena['sonido'])
                            <div class="mb-2">
                                <audio controls src="{{ asset($escena['sonido']) }}"></audio>
                            </div>
                            {{-- Campo oculto para conservar el audio actual --}}
                            <input type="hidden" name="escenas[{{ $escenaId }}][sonido]" value="{{ $escena['sonido'] }}">
                        @else
                            <p>No hay audio cargado.</p>
                        @endif
                    
                        <label class="fw-bold">Subir nuevo audio (.mp3) opcional:</label>
                        <input type="file" name="escenas[{{ $escenaId }}][audio]" accept="audio/mp3" class="form-control">
                    </div>
                    

                    <div class="mb-3">
                        <label class="fw-bold">Opciones de respuesta:</label>
                        <div class="opciones-container">
                            @foreach($escena['opciones'] as $opcionTexto => $escenaDestino)
                                <div class="row mb-2 opcion-row">
                                    <div class="col-md-5">
                                        <input type="text" name="opciones[{{ $escenaId }}][]" value="{{ $opcionTexto }}" class="form-control" placeholder="Respuesta">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="consecuencias[{{ $escenaId }}][]" value="{{ $escenaDestino }}" class="form-control" placeholder="Escena destino">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-opcion">Eliminar</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary add-opcion" data-escena="{{ $escenaId }}">Agregar opción</button>
                    </div>

                    <button type="button" class="btn btn-danger remove-escena">Eliminar Escena</button>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-success mb-4" id="add-escena">➕ Agregar nueva escena</button>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">💾 Guardar Cambios</button>
            <a href="{{ route('cuentacuentos.index') }}" class="btn btn-secondary btn-lg ms-2">↩️ Cancelar</a>
        </div>
    </form>
</div>

{{-- Plantilla oculta para nuevas escenas --}}
<template id="escena-template">
    <div class="card p-4 mb-4 escena-block">
        <h5>🎬 Escena: <input type="text" name="escenas[__INDEX__][nombre]" class="form-control" required></h5>

        <div class="mb-3">
            <label class="fw-bold">Texto:</label>
            <textarea name="escenas[__INDEX__][texto]" rows="3" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Subir audio (.mp3) opcional:</label>
            <input type="file" name="escenas[__INDEX__][audio]" accept="audio/mp3" class="form-control">
        </div>

        <div class="mb-3">
            <label class="fw-bold">Opciones de respuesta:</label>
            <div class="opciones-container">
                <div class="row mb-2 opcion-row">
                    <div class="col-md-5">
                        <input type="text" name="opciones[__INDEX__][]" class="form-control" placeholder="Respuesta">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="consecuencias[__INDEX__][]" class="form-control" placeholder="Escena destino">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-opcion">Eliminar</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary add-opcion" data-escena="__INDEX__">Agregar opción</button>
        </div>

        <button type="button" class="btn btn-danger remove-escena">Eliminar Escena</button>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let escenaIndex = {{ count($escenas) }};

        // Agregar nueva escena
        document.getElementById('add-escena').addEventListener('click', function () {
            const template = document.getElementById('escena-template').innerHTML;
            const newEscena = template.replace(/__INDEX__/g, escenaIndex);
            document.getElementById('escenas-container').insertAdjacentHTML('beforeend', newEscena);
            escenaIndex++;
        });

        // Delegar eventos para eliminar escena y opción
        document.getElementById('escenas-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-escena')) {
                e.target.closest('.escena-block').remove();
            }

            if (e.target.classList.contains('remove-opcion')) {
                e.target.closest('.opcion-row').remove();
            }

            if (e.target.classList.contains('add-opcion')) {
                const escenaId = e.target.getAttribute('data-escena');
                const opcionesContainer = e.target.previousElementSibling;
                const newOpcion = `
                    <div class="row mb-2 opcion-row">
                        <div class="col-md-5">
                            <input type="text" name="opciones[${escenaId}][]" class="form-control" placeholder="Respuesta">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="consecuencias[${escenaId}][]" class="form-control" placeholder="Escena destino">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-opcion">Eliminar</button>
                        </div>
                    </div>
                `;
                opcionesContainer.insertAdjacentHTML('beforeend', newOpcion);
            }
        });
    });
</script>
@endsection
