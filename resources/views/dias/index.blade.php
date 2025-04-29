@extends('layouts.app')

@section('title')
    Lista de dias
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Lista de dias de los cursos</h5>
                <h6 class="card-subtitle mb-2 text-muted">Maneja de la asistencias</h6>

                <div class="mb-2 text-start">
                    <a href="{{ route('cursos.index') }}" class="btn btn-primary btn-sm float-right">Volver atras</a>
                </div>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col" width="15%">FECHA</th>
                            <th scope="col" width="10%">CURSO</th>
                            <th scope="col" width="1%" colspan="4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dias as $dia)
                            <tr>
                                <th scope="row">{{ $dia->id }}</th>
                                <td>{{ $dia->fecha }}</td>
                                <td>{{ $dia->curso->nombre }}</td>
                                <td>
                                    <a href="{{ route('dias.asistencias', ['curso' => $curso->id, 'dia' => $dia->id]) }}"
                                        class="btn btn-success btn-sm">Marcar</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex">
                    {!! $dias->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
