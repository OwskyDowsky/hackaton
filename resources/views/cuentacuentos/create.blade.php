@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">📖 Crear Historia Interactiva</h1>

    <form method="POST" action="{{ route('cuentacuentos.store') }}" enctype="multipart/form-data" id="formHistoria">
        @csrf

        {{-- Título principal --}}
        <div class="mb-4">
            <label for="nombre" class="form-label fw-bold">Nombre de la Historia:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        {{-- Contenedor raíz del árbol --}}
        <div id="arbolEscenas">
            {{-- Primera escena --}}
            <div class="escena card p-4 mb-3 border-primary" data-nivel="0" data-id="inicio">
                @include('cuentacuentos.partials.escena', ['id' => 'inicio', 'nivel' => 0])
            </div>
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-success btn-lg">Guardar Historia</button>
        </div>
    </form>
</div>

{{-- Script para clonación dinámica --}}
<script>
    let escenaCount = 1;

    function agregarEscenaPadre(opcionInput) {
        const contenedor = document.createElement('div');
        const nuevaId = 'escena_' + escenaCount++;
        const nivel = parseInt(opcionInput.closest('.escena').dataset.nivel) + 1;

        contenedor.className = 'escena card p-4 mb-3 border-secondary';
        contenedor.dataset.nivel = nivel;
        contenedor.dataset.id = nuevaId;

        // ⚡ CORREGIDO: armar URL dinámica correctamente
        const url = `/cuentacuentos/escena?id=${encodeURIComponent(nuevaId)}&nivel=${nivel}`;

        fetch(url)
            .then(res => res.text())
            .then(html => {
                contenedor.innerHTML = html;
                document.getElementById('arbolEscenas').appendChild(contenedor);

                // Asignar nueva escena como destino
                const destinoInput = opcionInput.closest('.row').querySelector('.destinoEscena');
                destinoInput.value = nuevaId;
            })
            .catch(err => {
                console.error('Error al cargar nueva escena:', err);
            });
    }

    function agregarOpcion(btn) {
        const opcionesContainer = btn.previousElementSibling;
        const escenaId = btn.closest('.escena').dataset.id;

        const nuevaOpcion = `
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="opciones[${escenaId}][]" class="form-control" placeholder="Respuesta (ej: correr)" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="consecuencias[${escenaId}][]" class="form-control destinoEscena" placeholder="Escena destino" readonly>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="agregarEscenaPadre(this)">➕ Crear Escena</button>
            </div>
        </div>`;
        opcionesContainer.insertAdjacentHTML('beforeend', nuevaOpcion);
    }
</script>

@endsection
