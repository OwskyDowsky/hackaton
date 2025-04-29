<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\DiasAsistencias;
use App\Models\EstudiantesAsistencias;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiasController extends Controller
{
    public function index($cursoId)
    {
        // Obtener el curso
        $curso = Cursos::findOrFail($cursoId);

        // Verificar si ya existe un registro para el día de hoy
        $hoy = Carbon::today(); // Obtener la fecha de hoy

        $registroHoy = DiasAsistencias::where('curso_id', $cursoId)
            ->whereDate('fecha', $hoy)
            ->first(); // Buscar si existe un registro para hoy

        if (!$registroHoy) {
            // Si no existe, crear un nuevo registro
            DiasAsistencias::create([
                'curso_id' => $cursoId,  // Pasar el ID del curso
                'fecha' => $hoy,         // Pasar la fecha de hoy
            ]);
        }

        // Filtrar los días de asistencia por curso_id
        $dias = DiasAsistencias::where('curso_id', $cursoId)->latest()->paginate(10);

        // Retornar la vista con los datos
        return view('dias.index', compact('dias', 'curso'));
    }

    /*public function asistencias($curso, $diaId)
    {
        $dia = DiasAsistencias::findOrFail($diaId);
        return view('dias.asistencias', compact('dia'));
    }*/

    public function asistencias($cursoId, $diaId)
    {
        $dia = DiasAsistencias::findOrFail($diaId);
        $curso = Cursos::findOrFail($cursoId);

        // Obtener estudiantes del curso
        $estudiantes = $curso->estudiantes;

        // Obtener IDs de estudiantes que ya tienen asistencia ese día
        $asistenciasExistentes = EstudiantesAsistencias::where('curso_id', $cursoId)
            ->where('dia_id', $diaId)
            ->pluck('estudiante_id') // solo sacamos los IDs
            ->toArray();

        return view('dias.asistencias', compact('dia', 'curso', 'estudiantes', 'asistenciasExistentes'));
    }


    public function registrarAsistencia(Request $request, $cursoId, $diaId)
    {
        $request->validate([
            'estudiantes' => 'array',
            'estudiantes.*' => 'exists:users,id',
        ]);

        // Primero puedes eliminar asistencias anteriores si quieres "actualizar"
        EstudiantesAsistencias::where('curso_id', $cursoId)
            ->where('dia_id', $diaId)
            ->delete();

        // Luego insertar las nuevas asistencias
        if ($request->has('estudiantes')) {
            foreach ($request->estudiantes as $estudianteId) {
                EstudiantesAsistencias::create([
                    'curso_id' => $cursoId,
                    'estudiante_id' => $estudianteId,
                    'dia_id' => $diaId,
                    'asistencia' => 'si', // o 1 si es entero
                ]);
            }
        }

        return redirect()->route('dias.asistencias', ['curso' => $cursoId, 'dia' => $diaId])
            ->with('success', 'Asistencias registradas correctamente.');
    }
}
