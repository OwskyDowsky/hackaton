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
            'language' => 'required|in:es,en,pt',
            'output_name' => 'required|string|max:100'
        ]);

        try {
            set_time_limit(300); // ⏱ Aumentar tiempo de ejecución

            // Subir archivo
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $fullPath = public_path('storage/' . $path);

            $mode = $request->mode;
            $lang = $request->language;
            $outputNameRaw = $request->input('output_name');
            $outputName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $outputNameRaw);

            $pythonPath = 'C:/Python313/python.exe'; // Cambia si es necesario
            $scriptPath = base_path('python_braille/main.py');

            // 🚀 Pasamos --output como parámetro personalizado
            $command = "\"$pythonPath\" \"$scriptPath\" --file \"$fullPath\" --mode $mode --lang $lang --output \"$outputName\" 2>&1";

            $output = [];
            $retval = null;
            exec($command, $output, $retval);

            if ($retval === 0) {
                $textResult = implode("\n", $output);

                // Verificar si el archivo generado existe en public/outputs/
                $generatedPdfPath = public_path("outputs/{$outputName}_{$lang}.pdf");

                if (file_exists($generatedPdfPath)) {
                    // ✅ Aquí ya no movemos nada porque ya está en /public/outputs/
                    return back()
                        ->with('success', '✅ ¡Archivo procesado con éxito!')
                        ->with('output', $textResult)
                        ->with('pdf', 'outputs/' . basename($generatedPdfPath));
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
        $pdfDirectory = public_path('outputs');
        $files = [];

        if (file_exists($pdfDirectory)) {
            foreach (scandir($pdfDirectory) as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                    $files[] = 'outputs/' . $file;
                }
            }
        }

        return view('braille.list', compact('files'));
    }

    public function outputs()
    {
        $outputsPath = public_path('outputs');
        $files = [];

        if (file_exists($outputsPath)) {
            foreach (scandir($outputsPath) as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['pdf', 'txt'])) {
                    $files[] = 'outputs/' . $file;
                }
            }
        }

        return view('braille.outputs', compact('files'));
    }

    public function stop()
    {
        try {
            $path = storage_path('app/public/stop.flag');
            $dir = dirname($path);

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            file_put_contents($path, 'stop');

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
