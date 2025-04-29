<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CuentaCuentosController extends Controller
{
    public function index()
    {
        return view('cuentacuentos.index');
    }
    public function start()
    {
        $output = [];
        $retval = null;
    
        // Ruta absoluta al ejecutable de Python
        $pythonPath = 'C:/Users/urdin/AppData/Local/Programs/Python/Python311/python.exe';
    
        // Asegurar que la ruta al script esté 100% en formato Windows
        $scriptPath = base_path('python_scripts/narrador.py');
        $scriptPath = str_replace('/', '\\', $scriptPath); // <--- Muy importante
    
        $command = "\"$pythonPath\" \"$scriptPath\" 2>&1";
    
        exec($command, $output, $retval);
    
        if ($retval === 0) {
            echo "\n✅ Narrador iniciado correctamente.\n";
            return back()->with('success', '¡La aventura ha comenzado exitosamente!');
        } else {
            $errorMessage = implode("\n", $output);
            echo "\n❌ No se pudo iniciar el narrador. Detalles:\n$errorMessage\n";
    
            \Log::error('Error al iniciar narrador: ' . $errorMessage);
    
            return back()->with('error', 'No se pudo iniciar el narrador. Detalles: ' . $errorMessage);
        }
    }
    
    
}
