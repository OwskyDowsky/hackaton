@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>📂 Lista de PDFs Braille generados</h3>

    @if(count($files) > 0)
        <ul class="list-group mt-3">
            @foreach($files as $file)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ basename($file) }}
                    <a href="{{ asset($file) }}" class="btn btn-sm btn-primary" download>📥 Descargar</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay archivos generados aún.</p>
    @endif

    <a href="{{ route('braille.index') }}" class="btn btn-secondary mt-4">⬅ Volver</a>
</div>
@endsection
