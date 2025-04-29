import pyttsx3
import keyboard
import threading
import time

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
    """
    Monitorea si se presiona ESC para detener la lectura manualmente.
    """
    while not stop_flag['done'] and engine.isBusy():
        if keyboard.is_pressed('esc'):
            print("\nSe presionó ESC: deteniendo la lectura...")
            engine.stop()
            break
        time.sleep(0.1)

def read_text(text, preferred_language='es'):
    engine = pyttsx3.init()
    stop_flag = {'done': False}
    voices = list_voices(engine)
    selected_voice = None

    def matches_language(voice, lang_code):
        voice_lang = voice.languages[0] if voice.languages else ""
        return lang_code in (voice_lang.decode('utf-8') if isinstance(voice_lang, bytes) else voice_lang)

    # Selección de voz
    if preferred_language == 'es':
        for voice in voices:
            if 'Sabina' in voice.name:
                selected_voice = voice
                break
        if not selected_voice:
            selected_voice = next((v for v in voices if matches_language(v, 'es')), None)
    elif preferred_language == 'en':
        selected_voice = next((v for v in voices if matches_language(v, 'en')), None)
    elif preferred_language == 'pt':
        selected_voice = next((v for v in voices if matches_language(v, 'pt')), None)

    if selected_voice:
        engine.setProperty('voice', selected_voice.id)
        print(f"Usando voz automática: {selected_voice.name}")
    else:
        print("No se encontró voz específica, usando predeterminada.")

    engine.setProperty('rate', 150)
    engine.setProperty('volume', 1.0)

    try:
        # Inicia hilo para permitir interrupción por teclado
        keyboard_thread = threading.Thread(target=monitor_keyboard, args=(engine, stop_flag))
        keyboard_thread.start()

        engine.say(text)
        engine.runAndWait()

        stop_flag['done'] = True  # Marca que ya se terminó
        keyboard_thread.join(timeout=1.0)  # Asegura que el hilo termine
    finally:
        engine.stop()
        del engine
        print("🛑 Narración finalizada y motor de voz liberado.")
