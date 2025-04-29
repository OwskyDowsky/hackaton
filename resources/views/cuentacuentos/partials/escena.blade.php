@php
    $id = $id ?? 'inicio';
    $nivel = $nivel ?? 0;
@endphp

<div class="mb-3">
    <label class="fw-bold">Nombre interno (único) de la escena:</label>
    <input type="text" name="escenas[{{ $id }}][nombre]" value="{{ $id }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="fw-bold">Texto que se narrará:</label>
    <textarea name="escenas[{{ $id }}][texto]" rows="3" class="form-control" required></textarea>
</div>

<div class="mb-3">
    <label class="fw-bold">Audio opcional (.mp3):</label>
    <input type="file" name="escenas[{{ $id }}][audio]" accept="audio/mp3" class="form-control">
</div>

<div class="mb-3">
    <label class="fw-bold">Opciones de respuesta:</label>
    <div id="opciones_{{ $id }}"></div>
    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="agregarOpcion(this)">
        ➕ Agregar Opción
    </button>
</div>
