@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">🎙️ Bienvenido al CuentaCuentos</h1>

    {{-- Mensajes de éxito o error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Botones de iniciar y detener narrador --}}
    <div class="mb-4">
        <form method="POST" action="{{ route('cuentacuentos.start') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg">
                Iniciar Aventura ✨
            </button>
        </form>

        <form method="POST" action="{{ route('cuentacuentos.stop') }}" class="d-inline ms-2">
            @csrf
            <button type="submit" class="btn btn-danger btn-lg">
                Detener Narrador 🛑
            </button>
        </form>
    </div>

    {{-- Avance actual --}}
    @php
        $avancePath = storage_path('app/avance.txt');
        $avance = file_exists($avancePath) ? file_get_contents($avancePath) : 0;
    @endphp

    <div class="mt-4">
        <h4>Avance actual: {{ $avance }}%</h4>
        <div class="progress" style="height: 25px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $avance }}%;" aria-valuenow="{{ $avance }}" aria-valuemin="0" aria-valuemax="100">
                {{ $avance }}%
            </div>
        </div>
    </div>

    {{-- Selección de historias disponibles --}}
    <hr class="my-5">

    <h2 class="mb-3">📚 Seleccionar una Historia</h2>

    @if(isset($historias) && $historias->count())
        <div class="list-group">
            @foreach($historias as $historia)
                <form action="{{ route('historias.seleccionar', $historia->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="list-group-item list-group-item-action mb-2">
                        {{ $historia->nombre }}
                    </button>
                </form>
            @endforeach
        </div>
    @else
        <p>No hay historias disponibles aún.</p>
    @endif

    {{-- Formulario para agregar nueva historia --}}
    <hr class="my-5">

    <h2 class="mb-3">➕ Agregar Nueva Historia</h2>

    <form action="{{ route('historias.store') }}" method="POST" enctype="multipart/form-data" class="text-start">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Historia:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ejemplo: La Aventura en el Bosque" required>
        </div>

        <div class="mb-3">
            <label for="archivo_json" class="form-label">Archivo JSON de la Historia:</label>
            <input type="file" name="archivo_json" id="archivo_json" class="form-control" accept=".json" required>
        </div>

        <button type="submit" class="btn btn-success">
            Guardar Nueva Historia 📖
        </button>
    </form>

</div>
@endsection
