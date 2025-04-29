<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CuentaCuentosController extends Controller
{
    public function index(Request $request)
    {
        $query = Historia::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', '%' . $search . '%');
        }
    
        $historias = $query->orderBy('created_at', 'desc')->paginate(6); // 6 historias por página
    
        return view('cuentacuentos.index', compact('historias'));
    }
    
    public function create()
    {
        return view('cuentacuentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'escenas' => 'required|array',
        ]);

        try {
            $jsonFilename = $this->generarJsonHistoria($request);
            Historia::create([
                'nombre' => $request->nombre,
                'archivo_json' => $jsonFilename,
            ]);

            return redirect()->route('cuentacuentos.index')->with('success', 'Historia creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar historia: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar la historia.');
        }
    }
    public function edit($id)
    {
        $historia = Historia::findOrFail($id);
    
        $jsonPath = base_path('python_scripts/' . $historia->archivo_json);
        if (!File::exists($jsonPath)) {
            return redirect()->route('cuentacuentos.index')->with('error', 'El archivo JSON de esta historia no existe.');
        }
    
        $escenas = json_decode(file_get_contents($jsonPath), true);
    
        return view('cuentacuentos.edit', compact('historia', 'escenas'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'escenas' => 'required|array',
    ]);

    try {
        $historia = Historia::findOrFail($id);

        // Reemplazar el JSON existente
        $this->generarJsonHistoria($request, $historia->archivo_json);

        // Actualizar el nombre en la base de datos
        $historia->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('cuentacuentos.index')->with('success', 'Historia actualizada exitosamente.');
    } catch (\Exception $e) {
        Log::error('Error al actualizar historia: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al actualizar la historia.');
    }
}

    public function destroy($id)
    {
        try {
            $historia = Historia::findOrFail($id);

            $jsonPath = base_path('python_scripts/' . $historia->archivo_json);
            if (File::exists($jsonPath)) {
                File::delete($jsonPath);
            }

            $historia->delete();

            return redirect()->route('cuentacuentos.index')->with('success', 'Historia eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar historia: ' . $e->getMessage());
            return redirect()->route('cuentacuentos.index')->with('error', 'Error al eliminar la historia.');
        }
    }

    public function seleccionar($id)
    {
        try {
            $historia = Historia::findOrFail($id);
            $pathOrigen = base_path('python_scripts/' . $historia->archivo_json);
            $pathDestino = base_path('python_scripts/historia.json');

            if (!file_exists($pathOrigen)) {
                return redirect()->route('cuentacuentos.index')->with('error', 'El archivo de la historia no existe.');
            }

            copy($pathOrigen, $pathDestino);

            return redirect()->route('cuentacuentos.index')->with('success', 'Historia "' . $historia->nombre . '" seleccionada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al seleccionar historia: ' . $e->getMessage());
            return redirect()->route('cuentacuentos.index')->with('error', 'No se pudo seleccionar la historia: ' . $e->getMessage());
        }
    }

    public function start()
    {
        try {
            $pythonPath = 'C:/Users/urdin/AppData/Local/Programs/Python/Python311/python.exe'; 
            $scriptPath = base_path('python_scripts/narrador.py');
            $scriptPath = str_replace('/', '\\', $scriptPath);

            $detentePath = storage_path('app/detente.flag');
            if (file_exists($detentePath)) {
                unlink($detentePath);
            }

            if (!file_exists(base_path('python_scripts/historia.json'))) {
                return redirect()->route('cuentacuentos.index')->with('error', 'No hay historia seleccionada. Selecciona una primero.');
            }

            $command = "start /B \"\" \"$pythonPath\" \"$scriptPath\"";
            pclose(popen($command, 'r'));

            return redirect()->route('cuentacuentos.index')->with('success', '¡La aventura comenzó!');
        } catch (\Exception $e) {
            Log::error('Error al iniciar narrador: ' . $e->getMessage());
            return redirect()->route('cuentacuentos.index')->with('error', 'Error al iniciar el narrador.');
        }
    }

    public function stop()
    {
        try {
            $detentePath = storage_path('app/detente.flag');
            file_put_contents($detentePath, 'detente');

            return redirect()->route('cuentacuentos.index')->with('success', 'Narrador detenido exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al detener narrador: ' . $e->getMessage());
            return redirect()->route('cuentacuentos.index')->with('error', 'Error al detener el narrador.');
        }
    }

    // --- Método privado de apoyo para generar JSON
    private function generarJsonHistoria(Request $request, $archivoExistente = null)
    {
        $data = [];
        $carpetaAudio = 'cuentacuentos_audio';
        $pathAudio = public_path($carpetaAudio);

        if (!file_exists($pathAudio)) {
            mkdir($pathAudio, 0777, true);
        }

        foreach ($request->input('escenas') as $escenaId => $escenaData) {
            $nombreEscena = $escenaData['nombre'];
            $texto = $escenaData['texto'];
            $sonido = null;

         // Mantener el sonido anterior si no se sube uno nuevo
if ($request->hasFile("escenas.$escenaId.audio")) {
    $audio = $request->file("escenas.$escenaId.audio");
    $audioName = time() . '_' . $audio->getClientOriginalName();
    $audio->move($pathAudio, $audioName);
    $sonido = "$carpetaAudio/$audioName";
} elseif (isset($escenaData['sonido']) && !empty($escenaData['sonido'])) {
    // Conservar el audio actual si ya existía
    $sonido = $escenaData['sonido'];
} else {
    $sonido = null;
}

            $opciones = [];
            $respuestas = $request->input("opciones.$escenaId", []);
            $consecuencias = $request->input("consecuencias.$escenaId", []);

            foreach ($respuestas as $i => $respuesta) {
                $destino = $consecuencias[$i] ?? null;
                if ($respuesta && $destino) {
                    $opciones[$respuesta] = $destino;
                }
            }

            $data[$nombreEscena] = [
                'texto' => $texto,
                'sonido' => $sonido,
                'opciones' => $opciones
            ];
        }

        $nombreArchivo = $archivoExistente ?? time() . '_historia.json';
        $jsonPath = base_path('python_scripts/' . $nombreArchivo);

        file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $nombreArchivo;
    }
}
