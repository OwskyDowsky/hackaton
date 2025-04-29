<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\CeguerasEstudiantes;
use App\Models\EstudiantesPadres;
use App\Models\GradosProfesores;
use App\Models\MateriasProfesores;

/**
 *
 */
class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = User::role('Estudiantes')->get(); // Obtener los estudiantes con rol 'Estudiantes'
        $roles = Role::latest()->get(); // Obtener los roles disponibles

        return view('users.create', compact('students', 'roles')); // Pasar los estudiantes y roles a la vista
    }


    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // Crear el usuario con los datos validados
        $user = User::create(array_merge($request->validated(), [
            'password' => bcrypt('test')  // Recuerda usar una contraseña segura
        ]));

        // Asignar el rol al usuario
        if ($request->has('role') && $request->role) {
            $user->assignRole($request->role);  // Asigna el rol por el ID
        }

        if ($request->role == 2 && $request->has('grades')) {
            foreach ($request->grades as $grado) {
                GradosProfesores::create([
                    'usuario_id' => $user->id,
                    'grado' => $grado
                ]);
            }
        }

        if ($request->role == 2 && $request->has('subjects')) {
            foreach ($request->subjects as $materia) {
                MateriasProfesores::create([
                    'usuario_id' => $user->id,
                    'materia' => $materia
                ]);
            }
        }

        if ($request->role == 1 && $request->has('disability')) {
            foreach ($request->disability as $ceguera) {
                CeguerasEstudiantes::create([
                    'usuario_id' => $user->id,
                    'ceguera' => $ceguera
                ]);
            }
        }

        if ($request->role == 3 && $request->has('students')) {
            // Recorremos los estudiantes seleccionados por el padre
            foreach ($request->students as $estudiante_id) {
                EstudiantesPadres::create([
                    'padre_id' => $user->id, // El ID del padre recién creado
                    'estudiante_id' => $estudiante_id, // El ID del estudiante seleccionado
                ]);
            }
        }

        return redirect()->route('users.index')
            ->withSuccess(__('Usuario creado con exito.'));
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Obtener todos los roles
        $roles = Role::all();

        $students = [];
        if ($user->hasRole('Padre de familia')) {
            $students = User::whereHas('roles', function ($query) {
                $query->where('name', 'Estudiantes');
            })->get();
        }

        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => $roles, // Roles disponibles
            'students' => $students, // Estudiantes disponibles
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param ProfileUpdateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, ProfileUpdateRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }
}
