<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BrailleReaderController extends Controller
{
    public function index()
    {
        return view('braille.index');
    }

    public function start(Request $request)
    {
        $output = [];
        $retval = null;

        // Validar archivo
        if (!$request->hasFile('file')) {
            return back()->with('error', 'No se subió ningún archivo.');
        }

        $file = $request->file('file');
        $mode = $request->input('mode');
        $language = $request->input('language');

        // Guardar archivo en storage/app/public/braille_inputs
        $filePath = $file->storeAs('public/braille_inputs', $file->getClientOriginalName());
        $absoluteFilePath = storage_path('app/' . $filePath);

        // Ruta a Python y script
        $pythonPath = 'C:/Python313/python.exe';
        $scriptPath = base_path('python_braille/main.py');
        $scriptPath = str_replace('/', '\\', $scriptPath);
        $absoluteFilePath = str_replace('/', '\\', $absoluteFilePath);

        // Comando con argumentos
        $command = "\"$pythonPath\" \"$scriptPath\" \"$absoluteFilePath\" \"$mode\" \"$language\" 2>&1";

        exec($command, $output, $retval);

        if ($retval === 0) {
            return back()->with('success', '¡Braille Reader procesado exitosamente!')
                         ->with('output', implode("\n", $output))
                         ->with('language', $language)
                         ->with('console_log', "✅ Comando ejecutado correctamente: $command");
        } else {
            $errorMessage = implode("\n", $output);
            $debugInfo = "❌ Error al ejecutar comando:\n$command\n\nSalida:\n$errorMessage";

            Log::error('Error al iniciar Braille Reader: ' . $debugInfo);

            return back()->with('error', 'No se pudo procesar. Revisa la consola del navegador para más detalles.')
                         ->with('console_log', $debugInfo);
        }
    }
}
