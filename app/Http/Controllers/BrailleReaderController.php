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
            // Subir archivo a storage/app/public/uploads
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $fullPath = public_path('storage/' . $path);

            // Parámetros
            $mode = $request->mode;
            $lang = $request->language;

            // Configurar entorno Python
            $pythonPath = 'C:/Python313/python.exe'; // Ajusta según tu entorno
            $scriptPath = base_path('python_braille/main.py');

            // Armar comando
            $command = "\"$pythonPath\" \"$scriptPath\" --file \"$fullPath\" --mode $mode --lang $lang 2>&1";

            // Ejecutar
            $output = [];
            $retval = null;
            exec($command, $output, $retval);

            if ($retval === 0) {
                $textResult = implode("\n", $output);

                // Si se generó un PDF, moverlo a storage/public
                $generatedPdfPath = public_path("outputs/braille_{$lang}.pdf");
                if (file_exists($generatedPdfPath)) {
                    $newPdfName = 'braille_' . time() . ".pdf";
                    $finalPdfPath = public_path('storage/outputs/' . $newPdfName);
                    @mkdir(public_path('storage/outputs'), 0777, true);
                    rename($generatedPdfPath, $finalPdfPath);
                    return back()->with('success', '✅ ¡Archivo procesado con éxito!')
                                 ->with('output', $textResult)
                                 ->with('pdf', 'storage/outputs/' . $newPdfName);
                }

                return back()->with('success', '✅ ¡Archivo procesado con éxito!')
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
}
