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
        $output = [];
        $retval = null;

        $pythonPath = 'C:/Users/urdin/AppData/Local/Programs/Python/Python311/python.exe'; // Ajusta si cambias de máquina
        $scriptPath = base_path('python_scripts/narrador.py');
        $scriptPath = str_replace('/', '\\', $scriptPath);

        $command = "\"$pythonPath\" \"$scriptPath\" 2>&1";

        exec($command, $output, $retval);

        if ($retval === 0) {
            return back()->with('success', '¡La aventura fue completada exitosamente!');
        } else {
            $errorMessage = implode("\n", $output);
            Log::error('Error al iniciar narrador: ' . $errorMessage);
            return back()->with('error', 'No se pudo iniciar el narrador. Detalles: ' . $errorMessage);
        }
    }

    /**
     * Detiene la historia creando un archivo de bandera.
     */
    public function stop()
    {
        try {
            $detentePath = storage_path('app/detente.flag');

            // Crear el archivo bandera que Python detecta para detener
            file_put_contents($detentePath, 'detente');

            return back()->with('success', 'Se envió la orden para detener la historia.');
        } catch (\Exception $e) {
            Log::error('Error al intentar detener la historia: ' . $e->getMessage());
            return back()->with('error', 'No se pudo detener la historia. Error: ' . $e->getMessage());
        }
    }
}
