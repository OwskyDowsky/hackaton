@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">🎙️ CuentaCuentos - Historias Interactivas</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    {{-- Buscador --}}
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form method="GET" action="{{ route('cuentacuentos.index') }}" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="🔍 Buscar historia por nombre...">
                <button type="submit" class="btn btn-outline-primary">Buscar</button>
            </form>
        </div>
    </div>

    {{-- Botón crear historia --}}
    <div class="text-center mb-4">
        <a href="{{ route('cuentacuentos.create') }}" class="btn btn-success btn-lg">
            ➕ Nueva Historia
        </a>
    </div>

    @if($historias->count())
        <div class="row">
            @foreach($historias as $historia)
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body text-center">
                            <h4 class="card-title">{{ $historia->nombre }}</h4>

                            <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                                <form method="POST" action="{{ route('cuentacuentos.seleccionar', $historia->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        📖 Seleccionar
                                    </button>
                                </form>

                                <a href="{{ route('cuentacuentos.edit', $historia->id) }}" class="btn btn-warning btn-sm">
                                    ✏️ Editar
                                </a>

                                <form method="POST" action="{{ route('cuentacuentos.destroy', $historia->id) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta historia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $historias->appends(['search' => request('search')])->links() }}
        </div>

        {{-- Botones globales para narrador --}}
        <div class="text-center mt-5">
            <form method="POST" action="{{ route('cuentacuentos.start') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success btn-lg">
                    ▶️ Iniciar Narrador
                </button>
            </form>

            <form method="POST" action="{{ route('cuentacuentos.stop') }}" class="d-inline ms-3">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg">
                    ⏹️ Detener Narrador
                </button>
            </form>
        </div>

    @else
        <div class="alert alert-info text-center">
            No hay historias registradas aún. ¡Crea tu primera historia!
        </div>
    @endif
</div>
@endsection
