@extends('layouts.app')

@section('title')
    User List
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Usuarios</h5>
                <h6 class="card-subtitle mb-2 text-muted">Lista de los usuarios</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="mb-2 text-end">
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Agregar usuario</a>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col" width="15%">Name</th>
                            <th scope="col">Apellido paterno</th>
                            <th scope="col">Apellido materno</th>
                            <th scope="col">Email</th>
                            <th scope="col">CI</th>
                            <th scope="col" width="10%">Rol</th>
                            <th scope="col" width="1%" colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <th scope="row">{{ $user->name }}</th>
                                <th scope="row">{{ $user->apellido_paterno }}</th>
                                <th scope="row">{{ $user->apellido_materno }}</th>
                                <th scope="row">{{ $user->email }}</th>
                                <th scope="row">{{ $user->ci }}</th>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td><a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm">Ver</a>
                                </td>
                                <td><a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">Editar</a>
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">ELIMINAR</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex">
                    {!! $users->links() !!}
                </div>

            </div>
        </div>
    </div>
@endsection
