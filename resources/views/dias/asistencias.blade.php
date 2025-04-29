@extends('layouts.app')

@section('title')
    Asistencia del curso
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Asistencia de los estudiantes</h5>
                <div class="container">
                    <h3>Asistencias para el día: {{ $dia->fecha }}</h3>
                    <p>Curso: {{ $curso->nombre }}</p>

                    <div class="mt-2">
                        @include('layouts.includes.messages')
                    </div>

                    <form action="{{ route('dias.registrarAsistencia', ['curso' => $curso->id, 'dia' => $dia->id]) }}"
                        method="POST">
                        @csrf

                        <div class="mb-3">
                            <h6>Selecciona los estudiantes</h6>
                            <div class="row">
                                @foreach ($estudiantes as $estudiante)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="estudiantes[]"
                                                value="{{ $estudiante->id }}" id="estudiante_{{ $estudiante->id }}"
                                                {{ in_array($estudiante->id, $asistenciasExistentes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="estudiante_{{ $estudiante->id }}">
                                                {{ $estudiante->name }} {{ $estudiante->apellido_paterno }}
                                                ({{ $estudiante->ci }})
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="mb-2 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
