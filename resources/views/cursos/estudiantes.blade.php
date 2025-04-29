@extends('layouts.app')

@section('title')
    Asigna estudiantes al curso: {{ $curso->nombre }}
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Asigna estudiantes al curso: {{ $curso->nombre }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Selecciona los estudiantes para este curso</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <!-- Formulario para asignar estudiantes al curso -->
                <form action="{{ route('cursos.asignarEstudiantes', $curso->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <h6>Selecciona los estudiantes</h6>

                        <div class="row">
                            @foreach ($estudiantes as $estudiante)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="estudiantes[]"
                                            value="{{ $estudiante->id }}" id="estudiante_{{ $estudiante->id }}"
                                            {{ in_array($estudiante->id, $estudiantesAsignados) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="estudiante_{{ $estudiante->id }}">
                                            {{ $estudiante->name }} {{ $estudiante->apellido_paterno }}
                                            ({{ $estudiante->ci }})
                                            @if ($estudiante->cegueras->count())
                                                <br>
                                                <small>
                                                    Cegueras:
                                                    {{ $estudiante->cegueras->pluck('ceguera')->implode(', ') }}
                                                </small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="mb-2 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('cursos.index') }}" class="btn btn-default">Regresar</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
