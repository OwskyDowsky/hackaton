@extends('layouts.app')

@section('title')
    Lista de cursos
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cursos</h5>
                <h6 class="card-subtitle mb-2 text-muted">Maneja todos los cursos</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="mb-2 text-end">
                    <a href="{{ route('cursos.create') }}" class="btn btn-primary btn-sm float-right">Agregar un curso</a>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col" width="15%">NOMBRE</th>
                            <th scope="col" width="10%">GRADO</th>
                            <th scope="col" width="10%">CAPACIDAD</th>
                            <th scope="col" width="10%">TURNO</th>
                            <th scope="col" width="1%" colspan="4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cursos as $curso)
                            <tr>
                                <th scope="row">{{ $curso->id }}</th>
                                <td>{{ $curso->nombre }}</td>
                                <td>{{ $curso->grado }}</td>
                                <td>{{ $curso->capacidad }}</td>
                                <td>{{ $curso->turno }}</td>
                                <td><a href="{{ route('dias.index', $curso->id) }}"
                                        class="btn btn-success btn-sm">Asistencia</a></td>
                                <td><a href="{{ route('cursos.estudiantes', $curso->id) }}"
                                        class="btn btn-primary btn-sm">Estudiantes</a></td>
                                <td><a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-info btn-sm">Editar</a>
                                </td>
                                <td>
                                    <form action="{{-- route('curso.destroy', $curso->id) --}}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex">
                    {!! $cursos->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
