import pyttsx3
import json
import os
import time
import sys
import subprocess
import speech_recognition as sr

# Configuración
MICROFONO_INDEX = 2
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
historia_path = os.path.join(BASE_DIR, "historia.json")
avance_path = os.path.join(BASE_DIR, "..", "storage", "app", "avance.txt")
detente_flag_path = os.path.join(BASE_DIR, "..", "storage", "app", "detente.flag")
sonido_script = os.path.join(BASE_DIR, "sonido.py")

# Inicializar motor de voz
engine = pyttsx3.init()
engine.setProperty('rate', 145)
engine.setProperty('volume', 1.0)

# Escenas recorridas para calcular avance
escenas_visitadas = []

def narrar(texto):
    print(f"Narrando: {texto}")
    try:
        engine.say(texto)
        engine.runAndWait()
    except Exception as e:
        print(f"Error en narrador: {e}")

def reproducir_sonido(nombre_archivo):
    try:
        comando = [sys.executable, sonido_script, nombre_archivo]
        subprocess.Popen(comando)  # lanzamos sonido en otro proceso
    except Exception as e:
        print(f"Error al lanzar sonido: {e}")

def guardar_avance(porcentaje):
    try:
        with open(avance_path, "w", encoding="utf-8") as f:
            f.write(str(round(porcentaje, 2)))
    except Exception as e:
        print(f"Error guardando avance: {e}")

def calcular_avance(historia, escena_actual):
    escenas_visitadas.append(escena_actual)
    total = len(historia)
    recorridas = len(set(escenas_visitadas))
    porcentaje = (recorridas / total) * 100 if total > 0 else 0
    guardar_avance(porcentaje)
    print(f"Avance: {porcentaje:.2f}%")

def revisar_detencion():
    if os.path.exists(detente_flag_path):
        os.remove(detente_flag_path)
        narrar("Has detenido la historia. Hasta luego.")
        sys.exit(0)

def escuchar_respuesta(max_intentos=3):
    r = sr.Recognizer()
    intentos = 0

    while intentos < max_intentos:
        revisar_detencion()

        with sr.Microphone(device_index=MICROFONO_INDEX) as source:
            print("Escuchando tu decisión...")
            try:
                audio = r.listen(source, timeout=6)
                texto = r.recognize_google(audio, language="es-ES").lower()
                print(f"Detectado: {texto}")
                if "detente" in texto:
                    return "detente"
                return texto
            except sr.WaitTimeoutError:
                narrar("No te escuché. Inténtalo de nuevo.")
            except sr.UnknownValueError:
                narrar("No entendí lo que dijiste.")
            except sr.RequestError:
                narrar("Problemas de conexión de voz.")
                return "detente"

        intentos += 1

    return "detente"

def jugar():
    # Cargar historia
    try:
        with open(historia_path, 'r', encoding='utf-8') as f:
            historia = json.load(f)
    except FileNotFoundError:
        print("No se encontró el archivo historia.json")
        sys.exit(1)

    escena_actual = "inicio"

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

            time.sleep(0.5)
            narrar(escena['texto'])

            if not escena.get('opciones'):
                narrar("¡Fin de la historia! Gracias por acompañarme.")
                break

            opciones_disponibles = list(escena['opciones'].keys()) + ["detente"]

            respuesta_usuario = ""
            while respuesta_usuario not in opciones_disponibles:
                respuesta_usuario = escuchar_respuesta()
                if respuesta_usuario == "detente":
                    narrar("Te has detenido. Hasta pronto.")
                    return

            escena_actual = escena['opciones'].get(respuesta_usuario)

    except KeyboardInterrupt:
        narrar("La historia fue interrumpida manualmente.")

if __name__ == "__main__":
    jugar()
