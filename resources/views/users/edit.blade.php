@extends('layouts.app')

@section('title')
    Edit User
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Actualizar usuario</h5>
                <div class="container mt-4">
                    <form method="post" action="{{ route('users.update', $user->id) }}">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre del usuario</label>
                                    <input value="{{ $user->name }}" type="text" class="form-control" name="name"
                                        placeholder="Nombre del usuario" required>

                                    @if ($errors->has('name'))
                                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="apellido_paterno" class="form-label">Apellido paterno del usuario</label>
                                    <input value="{{ $user->apellido_paterno }}" type="text" class="form-control"
                                        name="apellido_paterno" placeholder="Apellido paterno del usuario" required>


                                    @if ($errors->has('apellido_paterno'))
                                        <span class="text-danger text-left">{{ $errors->first('apellido_paterno') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="apellido_materno" class="form-label">Apellido materno del usuario</label>
                                    <input value="{{ $user->apellido_materno }}" type="text" class="form-control"
                                        name="apellido_materno" placeholder="Apellido materno del usuario" required>

                                    @if ($errors->has('apellido_materno'))
                                        <span class="text-danger text-left">{{ $errors->first('apellido_materno') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" class="form-control" name="fecha_nacimiento"
                                        value="{{ $user->fecha_nacimiento }}" placeholder="Fecha de nacimiento del usuario"
                                        required>
                                    @if ($errors->has('fecha_nacimiento'))
                                        <span class="text-danger text-left">{{ $errors->first('fecha_nacimiento') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="ci" class="form-label">Carnet de identidad del usuario</label>
                                    <input value="{{ $user->ci }}" type="text" class="form-control" name="ci"
                                        placeholder="Carnet de identidad del usuario" required>

                                    @if ($errors->has('ci'))
                                        <span class="text-danger text-left">{{ $errors->first('ci') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input value="{{ $user->email }}" type="email" class="form-control" name="email"
                                        placeholder="Email address" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input value="{{ old('password') }}" type="password" class="form-control"
                                        name="password" placeholder="Contraseña del usuario">
                                    @if ($errors->has('password'))
                                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="celular" class="form-label">Celular del usuario</label>
                                    <input value="{{ $user->celular }}" type="text" class="form-control" name="celular"
                                        placeholder="Celular del usuario" required>
                                    @if ($errors->has('celular'))
                                        <span class="text-danger text-left">{{ $errors->first('celular') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="genero" class="form-label">Género</label>
                                    <select class="form-control" name="genero" required>
                                        <option value="">Seleccione género</option>
                                        <option value="hombre"
                                            {{ old('genero', $user->genero) == 'hombre' ? 'selected' : '' }}>Hombre
                                        </option>
                                        <option value="mujer"
                                            {{ old('genero', $user->genero) == 'mujer' ? 'selected' : '' }}>Mujer</option>
                                        <option value="otro"
                                            {{ old('genero', $user->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @if ($errors->has('genero'))
                                        <span class="text-danger text-left">{{ $errors->first('genero') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-control" name="role" id="roleSelect" required>
                                        <option value="">Selecciona el rol</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>

                                <!-- div solo si es profesor -->
                                <div class="mb-3" id="subjectsDiv"
                                    style="display: {{ $user->roles->first()->id == 2 ? 'block' : 'none' }};">
                                    <label for="subjects" class="form-label">Selecciona las materias</label>
                                    <select class="form-control" name="subjects[]" id="subjectsSelect" multiple
                                        style="width: 100%;">
                                        <option value="matematicas">Matemáticas</option>
                                        <option value="historia">Historia</option>
                                        <option value="geografia">Geografía</option>
                                    </select>
                                    @if ($errors->has('subjects'))
                                        <span class="text-danger text-left">{{ $errors->first('subjects') }}</span>
                                    @endif
                                </div>

                                <!-- div solo si es profesor -->
                                <div class="mb-3" id="gradesDiv"
                                    style="display: {{ $user->roles->first()->id == 2 ? 'block' : 'none' }};">
                                    <label for="grades" class="form-label">Selecciona los grados con los que
                                        trabajas</label>
                                    <select class="form-control" name="grades[]" id="gradesSelect" multiple
                                        style="width: 100%;">
                                        <option value="primero">Primero</option>
                                        <option value="segundo">Segundo</option>
                                        <option value="tercero">Tercero</option>
                                        <option value="cuarto">Cuarto</option>
                                        <option value="quinto">Quinto</option>
                                        <option value="sexto">Sexto</option>
                                    </select>
                                    @if ($errors->has('grades'))
                                        <span class="text-danger text-left">{{ $errors->first('grades') }}</span>
                                    @endif
                                </div>

                                <!-- div solo si es estudiante -->
                                <div class="mb-3" id="disabilityDiv"
                                    style="display: {{ $user->roles->first()->id == 1 ? 'block' : 'none' }};">
                                    <label for="disability" class="form-label">Selecciona el tipo de discapacidad
                                        visual</label>
                                    <select class="form-control" name="disability[]" id="disabilitySelect"
                                        multiple="multiple" style="width: 100%;">
                                        <option value="ceguera_parcial">Ceguera parcial</option>
                                        <option value="ceguera_total">Ceguera total</option>
                                        <option value="ceguera_periferica">Ceguera periférica</option>
                                        <option value="ceguera_central">Ceguera central</option>
                                    </select>
                                    @if ($errors->has('disability'))
                                        <span class="text-danger text-left">{{ $errors->first('disability') }}</span>
                                    @endif
                                </div>

                                <!-- div solo si es padre de familia -->
                                <div class="mb-3" id="studentsDiv"
                                    style="display: {{ $user->roles->first()->id == 3 ? 'block' : 'none' }};">
                                    <label for="students" class="form-label">Selecciona los estudiantes</label>
                                    <select class="form-control" name="students[]" id="studentsSelect" multiple
                                        style="width: 100%;">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}"
                                                {{ in_array($student->id, old('students', [])) ? 'selected' : '' }}>
                                                {{ $student->name }} ({{ $student->apellido_paterno }} -
                                                {{ $student->ci }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('students'))
                                        <span class="text-danger text-left">{{ $errors->first('students') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Update user</button>
                        <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                    </form>
                </div>
                <script>
                    // select2-init.js
                    document.addEventListener('DOMContentLoaded', function() {
                        // Inicializamos Select2 en el select de materias
                        $('#subjectsSelect').select2();

                        // Inicializamos Select2 en el select de grados (en caso de tenerlo)
                        $('#gradesSelect').select2();

                        // Inicializamos Select2 en el select de discapacidad visual (selección múltiple)
                        $('#disabilitySelect').select2(); // Aquí se añade el select de discapacidad

                        // Inicializamos Select2 en el select de estudiantes (para padres de familia)
                        $('#studentsSelect').select2(); // Aquí agregamos Select2 para el select de estudiantes
                    });
                    document.addEventListener('DOMContentLoaded', function() {
                        const roleSelect = document.getElementById('roleSelect');
                        const subjectsDiv = document.getElementById('subjectsDiv');
                        const gradesDiv = document.getElementById('gradesDiv');
                        const disabilityDiv = document.getElementById('disabilityDiv');
                        const studentsDiv = document.getElementById('studentsDiv');

                        // Función para mostrar/ocultar los divs según el rol seleccionado
                        function toggleRoleBasedDivs() {
                            if (roleSelect.value == '2') { // Ajusta '2' al ID de profesor
                                subjectsDiv.style.display = 'block';
                                gradesDiv.style.display = 'block';
                                disabilityDiv.style.display = 'none';
                                studentsDiv.style.display = 'none';
                            } else if (roleSelect.value == '1') { // ID '1' corresponde a estudiante
                                subjectsDiv.style.display = 'none';
                                gradesDiv.style.display = 'none';
                                disabilityDiv.style.display = 'block';
                                studentsDiv.style.display = 'none';
                            } else if (roleSelect.value == '3') { // ID '3' corresponde a padre
                                subjectsDiv.style.display = 'none';
                                gradesDiv.style.display = 'none';
                                disabilityDiv.style.display = 'none';
                                studentsDiv.style.display = 'block';
                            } else {
                                subjectsDiv.style.display = 'none';
                                gradesDiv.style.display = 'none';
                                disabilityDiv.style.display = 'none';
                                studentsDiv.style.display = 'none';
                            }
                        }

                        // Llamamos la función para ajustar la visibilidad al cargar la página
                        toggleRoleBasedDivs();

                        // Escuchamos el cambio en el select de roles
                        roleSelect.addEventListener('change', toggleRoleBasedDivs);
                    });
                </script>
            </div>
        </div>

    </div>
@endsection
