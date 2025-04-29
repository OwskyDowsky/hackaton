@extends('layouts.app')

@section('title')
    Editar curso
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actualizar curso</h5>

                <div class="container mt-4">
                    <form method="post" action="{{ route('cursos.update', $curso->id) }}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del curso</label>
                            <input value="{{ $curso->nombre }}" type="text" class="form-control" name="nombre"
                                placeholder="Nombre del curso" required>

                            @if ($errors->has('nombre'))
                                <span class="text-danger text-left">{{ $errors->first('nombre') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="grado" class="form-label">Grado</label>
                            <select class="form-control" id="grado" name="grado" required>
                                <option value="">Selecciona el grado</option>
                                <option value="primero" {{ $curso->grado == 'primero' ? 'selected' : '' }}>Primero</option>
                                <option value="segundo" {{ $curso->grado == 'segundo' ? 'selected' : '' }}>Segundo</option>
                                <option value="tercero" {{ $curso->grado == 'tercero' ? 'selected' : '' }}>Tercero</option>
                                <option value="cuarto" {{ $curso->grado == 'cuarto' ? 'selected' : '' }}>Cuarto</option>
                                <option value="quinto" {{ $curso->grado == 'quinto' ? 'selected' : '' }}>Quinto</option>
                                <option value="sexto" {{ $curso->grado == 'sexto' ? 'selected' : '' }}>Sexto</option>
                            </select>
                            @if ($errors->has('grado'))
                                <span class="text-danger">{{ $errors->first('grado') }}</span>
                            @endif
                        </div>


                        <div class="mb-3">
                            <label for="capacidad" class="form-label">Capacidad del curso</label>
                            <input value="{{ $curso->capacidad }}" type="number" class="form-control" id="capacidad"
                                name="capacidad" placeholder="Capacidad del curso" required>
                        </div>

                        <div class="mb-3">
                            <label for="turno" class="form-label">Turno del curso</label>
                            <select class="form-control" id="turno" name="turno" required>
                                <option value="">Selecciona el turno del curso</option>
                                <option value="dia" {{ $curso->turno == 'dia' ? 'selected' : '' }}>Día</option>
                                <option value="tarde" {{ $curso->turno == 'tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                            @if ($errors->has('turno'))
                                <span class="text-danger">{{ $errors->first('turno') }}</span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Actualizar producto</button>
                            <a href="{{ route('cursos.index') }}" class="btn btn-default btn-danger">Cancel</a>

                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
