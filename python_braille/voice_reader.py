import pyttsx3
import keyboard
import threading
import time
import os
import re

STOP_FILE = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', 'storage', 'app', 'public', 'stop.flag'))

def list_voices(engine):
    voices = engine.getProperty('voices')
    print("\nVoces disponibles en el sistema:")
    for idx, voice in enumerate(voices):
        lang = voice.languages[0] if voice.languages else "Desconocido"
        if isinstance(lang, bytes):
            lang = lang.decode('utf-8')
        print(f"{idx + 1}. {voice.name} - ({lang})")
    return voices

def monitor_keyboard(engine, stop_flag):
    while not stop_flag['done'] and engine.isBusy():
        if keyboard.is_pressed('esc'):
            print("\n[MANUAL] Se presionó ESC: deteniendo la lectura...")
            engine.stop()
            break
        if os.path.exists(STOP_FILE):
            print("[FLAG] Señal de parada detectada. Deteniendo...")
            engine.stop()
            break
        time.sleep(0.1)

def split_text_by_commas(text):
    # Solo hacer pausas en comas
    return [s.strip() + '.' for s in text.split(',') if s.strip()]

def clean_text(text):
    text = text.replace("Ã±", "ñ").replace("Ã¡", "á").replace("Ã©", "é")
    text = text.replace("Ã­", "í").replace("Ã³", "ó").replace("Ãº", "ú")
    text = text.replace("â", "-").replace("â", '"').replace("â", '"')
    
    # Elimina líneas irrelevantes
    pattern = r"(Leyendo texto en voz\.\.\.|Voces disponibles en el sistema:|^\d+\.\s.*\(Desconocido\)|^\[INFO\].*)"
    lines = text.splitlines()
    cleaned_lines = [line for line in lines if not re.search(pattern, line)]

    return " ".join(cleaned_lines)

def read_text(text, preferred_language='es'):
    if os.path.exists(STOP_FILE):
        os.remove(STOP_FILE)

    engine = pyttsx3.init()
    stop_flag = {'done': False}
    voices = list_voices(engine)
    selected_voice = next((v for v in voices if 'Sabina' in v.name), None)

    if selected_voice:
        engine.setProperty('voice', selected_voice.id)
        print(f"[INFO] Usando voz Sabina: {selected_voice.name}")
    else:
        print("[WARN] Voz Sabina no encontrada. Usando predeterminada.")

    engine.setProperty('rate', 150)
    engine.setProperty('volume', 1.0)

    text = clean_text(text)
    fragments = split_text_by_commas(text)

    try:
        keyboard_thread = threading.Thread(target=monitor_keyboard, args=(engine, stop_flag))
        keyboard_thread.start()

        for fragment in fragments:
            if stop_flag['done'] or os.path.exists(STOP_FILE):
                break
            engine.say(fragment)
            engine.runAndWait()

        stop_flag['done'] = True
        keyboard_thread.join(timeout=1.0)

    finally:
        engine.stop()
        if os.path.exists(STOP_FILE):
            os.remove(STOP_FILE)
        print("[INFO] Lectura finalizada correctamente.")
