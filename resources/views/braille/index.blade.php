@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>📖 Lector de Libros en Braille</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form id="formulario" action="{{ route('braille.start') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="file" class="form-label">Selecciona una imagen o PDF:</label>
            <input class="form-control" type="file" name="file" required>
        </div>

        <div class="mb-3">
            <label for="mode" class="form-label">Modo:</label>
            <select class="form-control" name="mode" id="modeSelect" required>
                <option value="voice">Lectura de voz 🎤</option>
                <option value="braille">Conversión a Braille ⠃</option>
            </select>
        </div>

        <div id="voiceSelectorContainer" class="mb-3" style="display: none;">
            <label for="voiceSelect" class="form-label">Selecciona la voz:</label>
            <select class="form-control" id="voiceSelect"></select>
        </div>

        <div class="mb-3">
            <label for="language" class="form-label">Idioma:</label>
            <select class="form-control" name="language" required>
                <option value="es">Español 🇪🇸</option>
                <option value="en">Inglés 🇺🇸</option>
                <option value="pt">Portugués 🇵🇹</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Procesar</button>
    </form>

    @if(session('output'))
        <div class="alert alert-info mt-4">
            <h5>Texto procesado:</h5>
            <pre id="textoProcesado">{{ session('output') }}</pre>
            <button id="releerBtn" class="btn btn-secondary mt-2">🔁 Releer</button>
        </div>
    @endif

    @if(session('pdf'))
        <a href="{{ asset(session('pdf')) }}" class="btn btn-success mt-3" download>
            📥 Descargar PDF Braille
        </a>

        <a href="{{ route('braille.list') }}" class="btn btn-outline-secondary mt-3">
            📂 Ver todos los PDFs generados
        </a>
    @endif

    @if(session('console_log'))
        <script>
            console.log(`{!! session('console_log') !!}`);
        </script>
    @endif

    <script>
        let selectedVoice = null;

        function cargarVoces() {
            const voices = speechSynthesis.getVoices();
            const voiceSelect = document.getElementById('voiceSelect');
            voiceSelect.innerHTML = '';

            voices.forEach((voice, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.textContent = `${voice.name} (${voice.lang})`;
                voiceSelect.appendChild(option);
            });

            if (voices.length > 0) {
                selectedVoice = voices[0];
            }

            voiceSelect.addEventListener('change', () => {
                selectedVoice = voices[voiceSelect.value];
            });
        }

        function leerTexto(texto) {
            if (!selectedVoice) {
                console.error('No hay voz seleccionada.');
                return;
            }
            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.voice = selectedVoice;
            utterance.rate = 1;
            speechSynthesis.speak(utterance);
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof speechSynthesis !== 'undefined') {
                cargarVoces();
                speechSynthesis.onvoiceschanged = cargarVoces;
            }

            const modeSelect = document.getElementById('modeSelect');
            const voiceSelectorContainer = document.getElementById('voiceSelectorContainer');

            modeSelect.addEventListener('change', function() {
                if (modeSelect.value === 'voice') {
                    voiceSelectorContainer.style.display = 'block';
                } else {
                    voiceSelectorContainer.style.display = 'none';
                }
            });

            @if(session('output'))
                const texto = document.getElementById('textoProcesado').textContent;
                setTimeout(() => { leerTexto(texto); }, 500);
            @endif

            document.getElementById('releerBtn')?.addEventListener('click', function () {
                const texto = document.getElementById('textoProcesado').textContent;
                leerTexto(texto);
            });
        });
    </script>
</div>
@endsection
