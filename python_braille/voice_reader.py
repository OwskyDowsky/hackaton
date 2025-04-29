import pyttsx3
import keyboard
import threading
import time

engine = pyttsx3.init()

def list_voices():
    """
    Lista todas las voces disponibles en el sistema de forma segura.
    """
    voices = engine.getProperty('voices')

    print("\nVoces disponibles en el sistema:")
    for idx, voice in enumerate(voices):
        if voice.languages and len(voice.languages) > 0:
            lang = voice.languages[0]
            if isinstance(lang, bytes):
                lang = lang.decode('utf-8')
        else:
            lang = "Desconocido"

        print(f"{idx + 1}. {voice.name} - ({lang})")

    return voices

def monitor_keyboard():
    """
    Monitorea si se presiona ESC para detener la voz.
    """
    while engine.isBusy():
        if keyboard.is_pressed('esc'):
            print("\nSe presionó ESC: deteniendo la lectura...")
            engine.stop()
            break
        time.sleep(0.1)

def read_text(text, preferred_language='es'):
    """
    Lee el texto en voz alta usando la voz adecuada automáticamente,
    y permite detener la lectura presionando ESC.
    preferred_language puede ser 'es', 'en', 'pt'
    """
    voices = list_voices()
    selected_voice = None

    # Buscar voz automática basada en preferencia
    if preferred_language == 'es':
        # Buscar Microsoft Sabina primero
        for voice in voices:
            if 'Sabina' in voice.name:
                selected_voice = voice
                break
        # Si no existe Sabina, buscar cualquier voz española
        if selected_voice is None:
            for voice in voices:
                if 'es' in voice.languages[0].decode('utf-8') if isinstance(voice.languages[0], bytes) else voice.languages[0]:
                    selected_voice = voice
                    break
    elif preferred_language == 'en':
        for voice in voices:
            if 'en' in voice.languages[0].decode('utf-8') if isinstance(voice.languages[0], bytes) else voice.languages[0]:
                selected_voice = voice
                break
    elif preferred_language == 'pt':
        for voice in voices:
            if 'pt' in voice.languages[0].decode('utf-8') if isinstance(voice.languages[0], bytes) else voice.languages[0]:
                selected_voice = voice
                break

    if selected_voice:
        engine.setProperty('voice', selected_voice.id)
        print(f"Usando voz automática: {selected_voice.name}")
    else:
        print("No se encontró una voz específica, usando predeterminada.")

    engine.setProperty('rate', 150)  # velocidad normal
    engine.setProperty('volume', 1.0)  # volumen máximo

    # Hilo para monitorear teclado mientras habla
    keyboard_thread = threading.Thread(target=monitor_keyboard)
    keyboard_thread.start()

    # Empieza a hablar
    engine.say(text)
    engine.runAndWait()

    keyboard_thread.join()
