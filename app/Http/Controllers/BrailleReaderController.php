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
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'mode' => 'required|in:voice,braille',
            'language' => 'required|in:es,en,pt'
        ]);

        try {
            set_time_limit(300); // ⏱ Aumentar tiempo de ejecución

            // Subir archivo a storage/app/public/uploads
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $fullPath = public_path('storage/' . $path);

            // Parámetros
            $mode = $request->mode;
            $lang = $request->language;

            // Configurar entorno Python
            $pythonPath = 'C:/Python313/python.exe'; // ⚠ Ajusta según tu máquina
            $scriptPath = base_path('python_braille/main.py');

            // Armar comando
            $command = "\"$pythonPath\" \"$scriptPath\" --file \"$fullPath\" --mode $mode --lang $lang 2>&1";

            // Ejecutar
            $output = [];
            $retval = null;
            exec($command, $output, $retval);

            if ($retval === 0) {
                $textResult = implode("\n", $output);

                // Buscar si se generó un PDF
                $generatedPdfPath = public_path("outputs/braille_{$lang}.pdf");
                if (file_exists($generatedPdfPath)) {
                    $newPdfName = 'braille_' . time() . ".pdf";

                    // Asegurar que exista storage/outputs
                    $storageOutputDir = public_path('storage/outputs');
                    if (!file_exists($storageOutputDir)) {
                        mkdir($storageOutputDir, 0777, true);
                    }

                    $finalPdfPath = $storageOutputDir . '/' . $newPdfName;
                    rename($generatedPdfPath, $finalPdfPath);

                    return back()
                        ->with('success', '✅ ¡Archivo procesado con éxito!')
                        ->with('output', $textResult)
                        ->with('pdf', 'storage/outputs/' . $newPdfName);
                }

                return back()
                    ->with('success', '✅ ¡Archivo procesado con éxito!')
                    ->with('output', $textResult);
            } else {
                $errorMessage = implode("\n", $output);
                Log::error('Error al procesar Braille: ' . $errorMessage);
                return back()->with('error', '❌ Fallo al ejecutar el script. Detalles: ' . $errorMessage);
            }

        } catch (\Exception $e) {
            Log::error('Excepción en BrailleReader: ' . $e->getMessage());
            return back()->with('error', '❌ Excepción: ' . $e->getMessage());
        }
    }

    public function list()
    {
        $pdfDirectory = public_path('storage/outputs');
        $files = [];

        if (file_exists($pdfDirectory)) {
            foreach (scandir($pdfDirectory) as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                    $files[] = 'storage/outputs/' . $file;
                }
            }
        }

        return view('braille.list', compact('files'));
    }

    public function stop()
    {
        try {
            file_put_contents(storage_path('app/public/stop.flag'), 'stop');
            return response()->json(['status' => 'ok', 'action' => 'stop']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al detener'], 500);
        }
    }
    
    public function pause()
    {
        try {
            file_put_contents(storage_path('app/public/pause.flag'), 'pause');
            return response()->json(['status' => 'ok', 'action' => 'pause']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al pausar'], 500);
        }
    }
    
    public function resume()
    {
        try {
            file_put_contents(storage_path('app/public/resume.flag'), 'resume');
            return response()->json(['status' => 'ok', 'action' => 'resume']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al reanudar'], 500);
        }
    }
    

}
