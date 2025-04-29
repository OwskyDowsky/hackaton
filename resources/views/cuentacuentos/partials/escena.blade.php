@php
    $id = $id ?? 'inicio';
    $nivel = $nivel ?? 0;
@endphp

<div class="mb-3">
    <label class="fw-bold">Nombre interno de la escena:</label>
    <input type="text" name="escenas[{{ $id }}][nombre]" value="{{ $id }}" class="form-control" required readonly>
</div>

<div class="mb-3">
    <label class="fw-bold">Texto narrado:</label>
    <textarea name="escenas[{{ $id }}][texto]" rows="3" class="form-control" required>{{ $escena['texto'] ?? '' }}</textarea>
</div>

<div class="mb-3">
    <label class="fw-bold">Audio actual:</label>
    @if(!empty($escena['sonido']))
        <div class="mb-2">
            <audio controls src="{{ asset($escena['sonido']) }}"></audio>
        </div>
    @else
        <p>No hay audio cargado.</p>
    @endif
</div>

<div class="mb-3">
    <label class="fw-bold">Subir nuevo audio (.mp3):</label>
    <input type="file" name="escenas[{{ $id }}][audio]" accept="audio/mp3" class="form-control">
</div>

<div class="mb-3">
    <label class="fw-bold">Opciones:</label>
    <div id="opciones_{{ $id }}">
        @if(!empty($escena['opciones']))
            @foreach($escena['opciones'] as $texto => $destino)
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" name="opciones[{{ $id }}][]" value="{{ $texto }}" class="form-control" placeholder="Respuesta" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="consecuencias[{{ $id }}][]" value="{{ $destino }}" class="form-control" placeholder="Escena destino" required>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <button type="button" onclick="agregarOpcion(this)" class="btn btn-sm btn-outline-primary mt-2">➕ Agregar Opción</button>
</div>

<script>
function agregarOpcion(btn) {
    const escena = btn.closest('.escena');
    const escenaId = escena.dataset.id;
    const container = btn.previousElementSibling;

    const nuevaOpcion = `
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" name="opciones[${escenaId}][]" class="form-control" placeholder="Respuesta" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="consecuencias[${escenaId}][]" class="form-control" placeholder="Escena destino" required>
        </div>
    </div>`;

    container.insertAdjacentHTML('beforeend', nuevaOpcion);
}
</script>
