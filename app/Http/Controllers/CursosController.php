<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\User;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index()
    {
        $cursos = Cursos::all();
        $cursos = Cursos::latest()->paginate(10);
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        $cursos = Cursos::all();

        // Pasar las categorías a la vista
        return view('cursos.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|max:255',
            'turno' => 'required',
        ]);

        // Crear el nuevo curso en la base de datos
        Cursos::create([
            'nombre' => $request->nombre,
            'grado' => $request->grado,
            'capacidad' => $request->capacidad,
            'turno' => $request->turno,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente.');
    }

    public function edit(Cursos $curso)
    {
        return view('cursos.edit', [
            'curso' => $curso,
            'nombre' => $curso->nombre,
            'grado' => $curso->grado,
            'capacidad' => $curso->capacidad,
            'turno' => $curso->turno,
        ]);
    }

    public function update(Request $request, Cursos $curso)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'grado' => 'required|max:255',
            'capacidad' => 'required|max:255',
            'turno' => 'required|',
        ]);

        // Actualizar los campos del producto
        $curso->update($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('cursos.index')->with('success', 'Curso actualizado exitosamente.');
    }

    public function estudiante($cursoId)
    {
        $curso = Cursos::findOrFail($cursoId);

        // Obtener todos los usuarios con el rol "Estudiantes"
        //$estudiantes = \App\Models\User::role('Estudiantes')->get();
        $estudiantes = \App\Models\User::role('Estudiantes')->with('cegueras')->get();


        // Obtener los IDs de los estudiantes ya asignados al curso
        $estudiantesAsignados = $curso->estudiantes->pluck('id')->toArray();

        return view('cursos.estudiantes', compact('curso', 'estudiantes', 'estudiantesAsignados'));
    }


    public function asignarEstudiantes(Request $request, $cursoId)
    {
        $curso = Cursos::findOrFail($cursoId);

        // Validar que se hayan enviado estudiantes
        $request->validate([
            'estudiantes' => 'array',
            'estudiantes.*' => 'exists:users,id',
        ]);

        // Guardar en la tabla intermedia (muchos a muchos)
        // Asegúrate que la relación esté definida en el modelo Cursos
        $curso->estudiantes()->sync($request->estudiantes);

        return redirect()->route('cursos.index')->with('success', 'Estudiantes asignados correctamente.');
    }
}
