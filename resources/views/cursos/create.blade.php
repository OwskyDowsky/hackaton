@extends('layouts.app')

@section('title')
    Agregar curso
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Agregar nuevo curso</h5>
                <h6 class="card-subtitle mb-2 text-muted">Complete el formulario para agregar un curso</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <!-- Formulario para agregar nuevo curso -->
                <form action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del curso</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                        placeholder="Nombre del curso" required>
                    </div>
                    <div class="mb-3">
                        <label for="grado" class="form-label">Grado</label>
                        <select class="form-control" id="grado" name="grado" required>
                            <option value="">Selecciona el grado</option>
                            <option value="primero">Primero</option>
                            <option value="segundo">Segundo</option>
                            <option value="tercero">Tercero</option>
                            <option value="cuarto">Cuarto</option>
                            <option value="quinto">Quinto</option>
                            <option value="sexto">Sexto</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad del curso</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" 
                        placeholder="Capacidad del curso" required>
                    </div>
                    <div class="mb-3">
                        <label for="turno" class="form-label">Turno del curso</label>
                        <select class="form-control" id="turno" name="turno" required>
                            <option value="">Selecciona el turno del curso</option>
                            <option value="dia">Dia</option>
                            <option value="tarde">Tarde</option>
                        </select>
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
