<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
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
}
