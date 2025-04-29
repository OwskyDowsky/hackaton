@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>📂 Archivos generados en <code>/outputs</code></h3>

    @if(count($files) > 0)
        <ul class="list-group mt-3">
            @foreach($files as $file)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>📘 {{ basename($file) }}</span>
                    <div class="d-flex gap-2">
                        <a href="{{ asset($file) }}" class="btn btn-sm btn-info" target="_blank">👁 Ver</a>
                        <a href="{{ asset($file) }}" class="btn btn-sm btn-success" download>📥 Descargar</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-warning mt-3">
            No hay archivos en la carpeta.
        </div>
    @endif

    <a href="{{ route('braille.index') }}" class="btn btn-secondary mt-4">⬅ Volver</a>
</div>
@endsection
