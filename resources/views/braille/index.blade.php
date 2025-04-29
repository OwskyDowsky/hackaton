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

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary" id="procesarBtn">Procesar</button>
            <button type="button" class="btn btn-danger" id="detenerBtnFormulario" style="display: none;">⛔ Detener lectura</button>
            <button type="button" class="btn btn-warning" id="pausarBtnFormulario" style="display: none;">⏸️ Pausar</button>
            <button type="button" class="btn btn-success" id="reanudarBtnFormulario" style="display: none;">▶️ Reanudar</button>
        </div>
    </form>

    @if(session('output'))
        <div class="alert alert-info mt-4">
            <h5>Texto procesado:</h5>
            <pre id="textoProcesado">{{ session('output') }}</pre>

            <div class="d-flex gap-2 mt-2">
                <button id="releerBtn" class="btn btn-secondary">🔁 Releer</button>
            </div>
        </div>
    @endif

    @if(session('pdf'))
        <div class="mt-4">
            <a href="{{ asset(session('pdf')) }}" class="btn btn-success mb-2" download>
                📥 Descargar PDF Braille
            </a>

            <a href="{{ route('braille.list') }}" class="btn btn-outline-secondary">
                📚 Ver todos los libros Braille generados
            </a>
        </div>
    @endif

    <script>
        let selectedVoice = null;
        let utterance = null;

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
                selectedVoice = voices.find(v => v.name.includes('Sabina')) || voices[0];
            }

            voiceSelect.addEventListener('change', () => {
                selectedVoice = voices[voiceSelect.value];
            });
        }

        function leerTexto(texto) {
            if (!selectedVoice) return;
            detenerLectura();
            utterance = new SpeechSynthesisUtterance(texto);
            utterance.voice = selectedVoice;
            utterance.rate = 1;
            speechSynthesis.speak(utterance);
        }

        function detenerLectura() {
            if (speechSynthesis.speaking || speechSynthesis.pending) {
                speechSynthesis.cancel();
            }
        }

        function pausarLectura() {
            if (speechSynthesis.speaking && !speechSynthesis.paused) {
                speechSynthesis.pause();
            }
        }

        function reanudarLectura() {
            if (speechSynthesis.paused) {
                speechSynthesis.resume();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof speechSynthesis !== 'undefined') {
                cargarVoces();
                speechSynthesis.onvoiceschanged = cargarVoces;
            }

            const modeSelect = document.getElementById('modeSelect');
            const voiceSelectorContainer = document.getElementById('voiceSelectorContainer');
            const detenerBtnFormulario = document.getElementById('detenerBtnFormulario');
            const pausarBtnFormulario = document.getElementById('pausarBtnFormulario');
            const reanudarBtnFormulario = document.getElementById('reanudarBtnFormulario');

            modeSelect.addEventListener('change', function() {
                if (modeSelect.value === 'voice') {
                    voiceSelectorContainer.style.display = 'block';
                } else {
                    voiceSelectorContainer.style.display = 'none';
                }
            });

            document.getElementById('formulario').addEventListener('submit', function () {
                if (modeSelect.value === 'voice') {
                    detenerBtnFormulario.style.display = 'inline-block';
                    pausarBtnFormulario.style.display = 'inline-block';
                    reanudarBtnFormulario.style.display = 'inline-block';
                }
            });

            document.getElementById('detenerBtnFormulario').addEventListener('click', function () {
                detenerLectura();
            });

            document.getElementById('pausarBtnFormulario').addEventListener('click', function () {
                pausarLectura();
            });

            document.getElementById('reanudarBtnFormulario').addEventListener('click', function () {
                reanudarLectura();
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

        document.getElementById('detenerBtnFormulario')?.addEventListener('click', function () {
    fetch('{{ route('braille.stop') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ok') {
            console.log('[✅] Señal de detener enviada correctamente');
        } else {
            console.error('[❌] Error al detener:', data.message);
        }
    })
    .catch(error => {
        console.error('[❌] Fallo de red o servidor al detener:', error);
    });
});

    </script>
    
</div>
@endsection