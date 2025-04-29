<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoriaController extends Controller
{
    public function index()
    {
        $historias = Historia::all();
        return view('cuentacuentos.index', compact('historias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'archivo_json' => 'required|file|mimes:json'
        ]);

        $file = $request->file('archivo_json');
        $path = $file->storeAs('cuentacuentos', $file->getClientOriginalName());

        Historia::create([
            'nombre' => $request->nombre,
            'archivo_json' => $path
        ]);

        return redirect()->route('cuentacuentos.index')->with('success', 'Historia creada correctamente.');
    }

    public function seleccionar($id)
    {
        $historia = Historia::findOrFail($id);

        $pathOrigen = storage_path('app/' . $historia->archivo_json);
        $pathDestino = base_path('python_scripts/historia.json');

        copy($pathOrigen, $pathDestino);

        return redirect()->route('cuentacuentos.index')->with('success', 'Historia seleccionada exitosamente.');
    }
}
