import pyttsx3
import json
import os
import time
import sys
import subprocess
import speech_recognition as sr
import psutil

# Configuración
MICROFONO_INDEX = 2
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
historia_path = os.path.join(BASE_DIR, "historia.json")
avance_path = os.path.join(BASE_DIR, "..", "storage", "app", "avance.txt")
detente_flag_path = os.path.join(BASE_DIR, "..", "storage", "app", "detente.flag")
sonido_script = os.path.join(BASE_DIR, "sonido.py")

# Inicializar motor de voz y configurar voz humana
engine = pyttsx3.init()

def configurar_voz(preferred_language='es'):
    voices = engine.getProperty('voices')
    selected_voice = None

    if preferred_language == 'es':
        # Buscar Microsoft Sabina primero
        for voice in voices:
            if 'Sabina' in voice.name:
                selected_voice = voice
                break
        # Si no está Sabina, cualquier voz española
        if selected_voice is None:
            for voice in voices:
                lang = voice.languages[0]
                if isinstance(lang, bytes):
                    lang = lang.decode('utf-8')
                if 'es' in lang:
                    selected_voice = voice
                    break

    if selected_voice:
        engine.setProperty('voice', selected_voice.id)
        print(f"Usando voz: {selected_voice.name}")
    else:
        print("Voz española no encontrada. Se usará voz predeterminada.")

    # Configurar volumen y velocidad base
    engine.setProperty('rate', 130)  # Base (ajustable luego en narrar)
    engine.setProperty('volume', 1.0)

# Configurar voz al iniciar el programa
configurar_voz()

escenas_visitadas = []
procesos_sonido = []

def narrar(texto, tipo="normal"):
    try:
        # Ajuste del tono base por tipo
        if tipo == "normal":
            base_rate = 130
        elif tipo == "misterio":
            base_rate = 115
        elif tipo == "fiesta":
            base_rate = 150
        else:
            base_rate = 130

        # Aplicar rate base
        engine.setProperty('rate', base_rate)

        # Dividir el texto en frases naturales
        frases = texto.replace('?', '.').replace('!', '.').split('.')
        for frase in frases:
            frase = frase.strip()
            if frase:
                longitud = len(frase.split())

                # Ajustar la velocidad dinámicamente según la longitud
                if longitud <= 5:
                    engine.setProperty('rate', base_rate + 10)
                elif longitud >= 15:
                    engine.setProperty('rate', base_rate - 10)
                else:
                    engine.setProperty('rate', base_rate)

                engine.say(frase)
                engine.runAndWait()

                # Pausa adaptativa después de cada frase
                if longitud <= 5:
                    time.sleep(0.3)
                elif longitud >= 15:
                    time.sleep(0.6)
                else:
                    time.sleep(0.4)
    except Exception:
        pass



def reproducir_sonido(nombre_archivo):
    try:
        comando = [sys.executable, sonido_script, nombre_archivo]
        proceso = subprocess.Popen(comando)
        procesos_sonido.append(proceso)
    except Exception:
        pass

def detener_sonidos():
    for proceso in procesos_sonido:
        try:
            parent = psutil.Process(proceso.pid)
            for child in parent.children(recursive=True):
                child.kill()
            parent.kill()
        except Exception:
            pass

def guardar_avance(porcentaje):
    try:
        with open(avance_path, "w", encoding="utf-8") as f:
            f.write(str(round(porcentaje, 2)))
    except Exception:
        pass

def calcular_avance(historia, escena_actual):
    escenas_visitadas.append(escena_actual)
    total = len(historia)
    recorridas = len(set(escenas_visitadas))
    porcentaje = (recorridas / total) * 100 if total > 0 else 0
    guardar_avance(porcentaje)

def revisar_detencion():
    if os.path.exists(detente_flag_path):
        detener_sonidos()
        narrar("Has detenido la historia. Hasta luego.")
        sys.exit(0)

def listar_opciones(opciones):
    if opciones:
        frases = []
        for opcion in opciones:
            frases.append(f"di {opcion}")
        return ", ".join(frases)
    return ""

def escuchar_respuesta(opciones_disponibles, max_intentos=3):
    r = sr.Recognizer()
    intentos = 0

    while intentos < max_intentos:
        revisar_detencion()

        with sr.Microphone(device_index=MICROFONO_INDEX) as source:
            try:
                audio = r.listen(source, timeout=6)
                texto = r.recognize_google(audio, language="es-ES").lower()

                if "detente" in texto:
                    return "detente"

                if texto in opciones_disponibles:
                    return texto
                else:
                    narrar(f"No entendí. Puedes {listar_opciones(opciones_disponibles)}.")
            except (sr.WaitTimeoutError, sr.UnknownValueError):
                narrar(f"No te escuché. Recuerda: puedes {listar_opciones(opciones_disponibles)}.")
            except sr.RequestError:
                narrar("Problemas de conexión de voz.")
                return "detente"

        intentos += 1

    return "detente"

def jugar():
    try:
        with open(historia_path, 'r', encoding='utf-8') as f:
            historia = json.load(f)
    except FileNotFoundError:
        narrar("Error cargando la historia.")
        sys.exit(1)

    # Seleccionar el primer nodo dinámicamente
    escena_actual = next(iter(historia))  # El primer elemento del diccionario

    try:
        while escena_actual:
            revisar_detencion()

            escena = historia.get(escena_actual)
            if not escena:
                narrar("No se pudo continuar la historia.")
                break

            calcular_avance(historia, escena_actual)

            if escena.get('sonido'):
                reproducir_sonido(escena['sonido'])

            # Ajustar tipo de narración según contexto
            tipo_narracion = "normal"

            if "cueva" in escena_actual or "oscuro" in escena_actual:
                tipo_narracion = "misterio"
            elif "castillo" in escena_actual or "fiesta" in escena_actual or "aldea" in escena_actual:
                tipo_narracion = "fiesta"

            narrar(escena['texto'], tipo=tipo_narracion)

            if not escena.get('opciones'):
                narrar("¡Fin de la historia! Gracias por acompañarme.")
                break

            opciones_disponibles = list(escena['opciones'].keys()) + ["detente"]

            respuesta_usuario = ""
            while respuesta_usuario not in opciones_disponibles:
                respuesta_usuario = escuchar_respuesta(opciones_disponibles)

                if respuesta_usuario == "detente":
                    narrar("Te has detenido. Hasta pronto.")
                    detener_sonidos()
                    return

            escena_actual = escena['opciones'].get(respuesta_usuario)

    except KeyboardInterrupt:
        narrar("La historia fue interrumpida manualmente.")
    finally:
        detener_sonidos()


if __name__ == "__main__":
    jugar()
