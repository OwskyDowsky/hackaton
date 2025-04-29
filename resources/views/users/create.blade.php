@extends('layouts.app')

@section('title')
    Create User
@endsection

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">Agregar nuevo usuario</h5>
                <div class="lead">
                    Agrega un nuevo usuario y su rol.
                </div>

                <div class="container mt-4">
                    <form method="POST" action="">
                        @csrf
                        <div class="row"> <!-- Aquí agregamos el contenedor de 2 columnas -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre del usuario</label>
                                    <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                        placeholder="Nombre el usuario" required>
                                    @error('name')
                                        <span class="text-danger text-left">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="apellido_paterno" class="form-label">Apellido paterno del usuario</label>
                                    <input value="{{ old('apellido_paterno') }}" type="text" class="form-control"
                                        name="apellido_paterno" placeholder="Apellido paterno del usuario" required>
                                    @if ($errors->has('apellido_paterno'))
                                        <span class="text-danger text-left">{{ $errors->first('apellido_paterno') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="apellido_materno" class="form-label">Apellido materno del usuario</label>
                                    <input value="{{ old('apellido_materno') }}" type="text" class="form-control"
                                        name="apellido_materno" placeholder="Apellido materno del usuario" required>
                                    @if ($errors->has('apellido_materno'))
                                        <span class="text-danger text-left">{{ $errors->first('apellido_materno') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="ci" class="form-label">Carnet de identidad del usuario</label>
                                    <input value="{{ old('ci') }}" type="text" class="form-control" name="ci"
                                        placeholder="Carnet de identidad del usuario" required>
                                    @if ($errors->has('ci'))
                                        <span class="text-danger text-left">{{ $errors->first('ci') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" class="form-control" name="fecha_nacimiento"
                                        value="{{ old('fecha_nacimiento') }}" placeholder="Fecha de nacimiento del usuario"
                                        required>
                                    @if ($errors->has('fecha_nacimiento'))
                                        <span class="text-danger text-left">{{ $errors->first('fecha_nacimiento') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input value="{{ old('email') }}" type="email" class="form-control" name="email"
                                        placeholder="Email address" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input value="{{ old('password') }}" type="password" class="form-control"
                                        name="password" placeholder="Contraseña del usuario" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="celular" class="form-label">Celular del usuario</label>
                                    <input value="{{ old('celular') }}" type="text" class="form-control" name="celular"
                                        placeholder="Celular del usuario" required>
                                    @if ($errors->has('celular'))
                                        <span class="text-danger text-left">{{ $errors->first('celular') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="genero" class="form-label">Género</label>
                                    <select class="form-control" name="genero" required>
                                        <option value="">Seleccione género</option>
                                        <option value="hombre" {{ old('genero') == 'hombre' ? 'seleccionado' : '' }}>Hombre
                                        </option>
                                        <option value="mujer" {{ old('genero') == 'mujer' ? 'seleccionado' : '' }}>Mujer
                                        </option>
                                        <option value="otro" {{ old('genero') == 'otro' ? 'seleccionado' : '' }}>Otro
                                        </option>
                                    </select>
                                    @if ($errors->has('genero'))
                                        <span class="text-danger text-left">{{ $errors->first('genero') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Assigna el rol</label>
                                    <select class="form-control" name="role" id="roleSelect" required>
                                        <option value="">Selecciona el rol</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>

                                <!-- div solo si es profesor -->
                                <div class="mb-3" id="subjectsDiv"
                                    style="display: {{ old('role') == '2' ? 'block' : 'none' }};">
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
                                    style="display: {{ old('role') == '2' ? 'block' : 'none' }};">
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
                                    style="display: {{ old('role') == '1' ? 'block' : 'none' }};">
                                    <label for="disability" class="form-label">Selecciona el tipo de discapacidad
                                        visual</label>
                                    <select class="form-control" name="disability[]" id="disabilitySelect"
                                        multiple="multiple" style="width: 100%;">
                                        <option value="ceguera_parcial">Ceguera
                                            parcial</option>
                                        <option value="ceguera_total">Ceguera total
                                        </option>
                                        <option value="ceguera_total">Ceguera periferica
                                        </option>
                                        <option value="ceguera_total">Ceguera central
                                        </option>
                                    </select>
                                    @if ($errors->has('disability'))
                                        <span class="text-danger text-left">{{ $errors->first('disability') }}</span>
                                    @endif
                                </div>

                                <!-- div padre de familia select hijo -->
                                <div class="mb-3" id="studentsDiv"
                                    style="display: {{ old('role') == '3' ? 'block' : 'none' }};">
                                    <label for="students" class="form-label">Selecciona los estudiantes</label>
                                    <select class="form-control" name="students[]" id="studentsSelect" multiple
                                        style="width: 100%;">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}"
                                                {{ in_array($student->id, old('students', [])) ? 'selected' : '' }}>
                                                {{ $student->name }} ({{ $student->apellido_paterno }})
                                                ({{ $student->ci }})
                                                <!-- Aquí puedes mostrar más campos, como el nombre y grado del estudiante -->
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('students'))
                                        <span class="text-danger text-left">{{ $errors->first('students') }}</span>
                                    @endif
                                </div>


                            </div>

                        </div> <!-- Fin del contenedor de las dos columnas -->

                        <button type="submit" class="btn btn-primary">Guardar usuario</button>
                        <a href="{{ route('users.index') }}" class="btn btn-default">Regresar</a>
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

                    // role-toggle.js
                    document.addEventListener('DOMContentLoaded', function() {
                        const roleSelect = document.getElementById('roleSelect');
                        const subjectsDiv = document.getElementById('subjectsDiv');
                        const gradesDiv = document.getElementById('gradesDiv');
                        const disabilityDiv = document.getElementById('disabilityDiv');
                        const studentsDiv = document.getElementById('studentsDiv'); // Añadimos el div de estudiantes

                        // Función para mostrar/ocultar los divs según el rol seleccionado
                        function toggleRoleBasedDivs() {
                            if (roleSelect.value == '2') { // Ajusta 'profesor_id' al ID real del rol de profesor
                                subjectsDiv.style.display = 'block';
                                gradesDiv.style.display = 'block';
                                disabilityDiv.style.display = 'none'; // Aseguramos que el div de discapacidad esté oculto
                                studentsDiv.style.display = 'none'; // Ocultar el div de estudiantes cuando el rol sea profesor
                            } else if (roleSelect.value == '1') { // El ID '1' corresponde al rol de estudiante
                                subjectsDiv.style.display = 'none'; // Ocultar materias
                                gradesDiv.style.display = 'none'; // Ocultar grados
                                disabilityDiv.style.display = 'block'; // Mostrar select de discapacidad visual
                                studentsDiv.style.display = 'none'; // Aseguramos que el div de estudiantes esté oculto
                            } else if (roleSelect.value == '3') { // El ID '3' corresponde al rol de padre
                                subjectsDiv.style.display = 'none'; // Ocultar materias
                                gradesDiv.style.display = 'none'; // Ocultar grados
                                disabilityDiv.style.display = 'none'; // Ocultar el select de discapacidad
                                studentsDiv.style.display = 'block'; // Mostrar div de selección de estudiantes
                            } else {
                                subjectsDiv.style.display = 'none';
                                gradesDiv.style.display = 'none';
                                disabilityDiv.style.display = 'none'; // Ocultar el div de discapacidad
                                studentsDiv.style.display = 'none'; // Aseguramos que el div de estudiantes también esté oculto
                            }
                        }

                        // Llamamos la función para ajustar la visibilidad según el valor actual del select al cargar
                        toggleRoleBasedDivs();

                        // Escuchamos cambios en el select de roles
                        roleSelect.addEventListener('change', toggleRoleBasedDivs);
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
