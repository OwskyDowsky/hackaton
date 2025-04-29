<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CuentaCuentosController extends Controller
{
    /**
     * Muestra la vista principal del cuentacuentos.
     */
    public function index()
    {
        return view('cuentacuentos.index');
    }

    /**
     * Inicia la historia ejecutando el script de narrador.
     */
    public function start()
    {
        try {
            $pythonPath = 'C:/Users/urdin/AppData/Local/Programs/Python/Python311/python.exe'; 
            $scriptPath = base_path('python_scripts/narrador.py');
            $scriptPath = str_replace('/', '\\', $scriptPath);

            // Limpiar el detente.flag antes de iniciar
            $detentePath = storage_path('app/detente.flag');
            if (file_exists($detentePath)) {
                unlink($detentePath);
            }

            // Lanzar en segundo plano en Windows
            $command = "start /B \"\" \"$pythonPath\" \"$scriptPath\"";

            pclose(popen($command, 'r'));

            return redirect()->route('cuentacuentos.index')->with('success', '¡La aventura comenzó! Puedes detenerla cuando quieras.');
        } catch (\Exception $e) {
            Log::error('Error al iniciar narrador: ' . $e->getMessage());
            return redirect()->route('cuentacuentos.index')->with('error', 'No se pudo iniciar el narrador. Error: ' . $e->getMessage());
        }
    }

    /**
     * Detiene la historia creando un archivo de bandera.
     */
    public function stop()
    {
        try {
            $detentePath = storage_path('app/detente.flag');
            file_put_contents($detentePath, 'detente');
    
            return redirect()->route('cuentacuentos.index')->with('success', 'Narrador detenido exitosamente. ¡Te esperamos en otra aventura!');
        } catch (\Exception $e) {
            Log::error('Error al intentar detener la historia: ' . $e->getMessage());
            return redirect()->route('cuentacuentos.index')->with('error', 'No se pudo detener la historia. Error: ' . $e->getMessage());
        }
    }
    
}
