@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Estadísticas -->
        <div class="col-12 col-lg-8">
            <div class="row">
                @php
                    $stats = [
                        ['label' => 'Estudiantes registrados', 'count' => $cantidadEstudiantes, 'color' => 'primary'],
                        ['label' => 'Profesores registrados', 'count' => $cantidadProfesores, 'color' => 'warning'],
                        ['label' => 'Padres de familia registrados', 'count' => $cantidadPadres, 'color' => 'danger'],
                        ['label' => 'Usuarios en total', 'count' => $cantidadUsuarios, 'color' => 'info']
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="col-sm-6 col-lg-6 mb-3">
                        <div class="card text-white bg-{{ $stat['color'] }} shadow-sm">
                            <div class="card-body">
                                <div class="fs-4 fw-semibold">{{ $stat['count'] }}</div>
                                <div>{{ $stat['label'] }}</div>
                                <div class="progress progress-white progress-thin my-2">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <small class="text-medium-emphasis-inverse">Progreso</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Comunicación Serial -->
        <div class="col-12 col-lg-4">
            <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 1.5rem;">
                <h4 class="text-center text-dark mb-3">📡 Comunicación Serial</h4>
                
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button id="connect" class="btn btn-primary flex-grow-1">Conectar Puerto</button>
                    <button id="disconnect" class="btn btn-secondary flex-grow-1" disabled>Desconectar</button>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <input type="text" id="textToSend" class="form-control" placeholder="Escribe tu mensaje">
                    <button id="send" class="btn btn-success" disabled>Enviar</button>
                </div>

                <div>
                    <h6 class="text-muted">📥 Datos recibidos:</h6>
                    <pre id="output" class="border rounded p-2 bg-light" style="max-height: 200px; overflow-y: auto;"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let port, writer, reader, keepReading = false;

    const connectBtn    = document.getElementById('connect');
    const disconnectBtn = document.getElementById('disconnect');
    const sendBtn       = document.getElementById('send');
    const textInput     = document.getElementById('textToSend');
    const outputEl      = document.getElementById('output');

    connectBtn.addEventListener('click', async () => {
        try {
            port = await navigator.serial.requestPort();
            await port.open({ baudRate: 9600 });

            writer = port.writable.getWriter();

            const decoder = new TextDecoderStream();
            port.readable.pipeTo(decoder.writable);
            reader = decoder.readable.getReader();
            keepReading = true;
            readLoop();

            connectBtn.disabled    = true;
            disconnectBtn.disabled = false;
            sendBtn.disabled       = false;
        } catch (err) {
            alert('No se pudo conectar al puerto.');
            console.error(err);
        }
    });

    disconnectBtn.addEventListener('click', async () => {
        keepReading = false;
        if (reader) await reader.cancel();
        if (writer) await writer.close();
        await port.close();

        connectBtn.disabled    = false;
        disconnectBtn.disabled = true;
        sendBtn.disabled       = true;
        outputEl.textContent = '';
    });

    sendBtn.addEventListener('click', async () => {
        const text = textInput.value.trim();
        if (text && writer) {
            const encoder = new TextEncoder();
            await writer.write(encoder.encode(text + '\n'));
            textInput.value = '';
        }
    });

    async function readLoop() {
        try {
            while (keepReading) {
                const { value, done } = await reader.read();
                if (done) break;
                if (value) {
                    outputEl.textContent += value;
                    outputEl.scrollTop = outputEl.scrollHeight;
                }
            }
        } catch (err) {
            console.error('Error en lectura:', err);
        }
    }
</script>
@endsection
