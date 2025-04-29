import pyttsx3
import json
import os
import time

# Inicializar motor de voz
engine = pyttsx3.init()

# Función para listar voces disponibles
def listar_voces():
    voices = engine.getProperty('voices')
    print("\nVoces disponibles:")
    for idx, voice in enumerate(voices):
        print(f"  {idx}: {voice.name} - {voice.id}")
    print()  # Espacio en blanco

# Función para configurar voz, velocidad y volumen
def configurar_voz(voz_index=0, velocidad=150, volumen=1.0):
    voices = engine.getProperty('voices')

    if 0 <= voz_index < len(voices):
        engine.setProperty('voice', voices[voz_index].id)
        print(f" Voz seleccionada: {voices[voz_index].name}")
    else:
        print(" Índice de voz inválido. Se usará la voz predeterminada.")

    engine.setProperty('rate', velocidad)  # velocidad de lectura
    engine.setProperty('volume', volumen)  # volumen (entre 0.0 y 1.0)

# Función para narrar texto
def narrar(texto):
    print(f"[Narrando]: {texto}")
    engine.say(texto)
    engine.runAndWait()

# Cargar historia desde JSON
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
historia_path = os.path.join(BASE_DIR, "historia.json")

try:
    with open(historia_path, 'r', encoding='utf-8') as f:
        historia = json.load(f)
except FileNotFoundError:
    print(" Error: No se encontró el archivo historia.json")
    exit(1)

# Función principal para jugar el cuento
def jugar():
    escena_actual = "inicio"

    while escena_actual:
        escena = historia.get(escena_actual)

        if not escena:
            narrar("La historia no pudo continuar. Algo falta.")
            break

        narrar(escena['texto'])
        time.sleep(1)

        if not escena.get('opciones'):
            narrar("Fin de la historia. ¡Gracias por jugar!")
            break

        print("Opciones disponibles:", ", ".join(escena['opciones'].keys()))
        escena_actual = next(iter(escena['opciones'].values()))  # Sigue la primera opción disponible

# Ejecución principal
if __name__ == "__main__":
    listar_voces()  # Opcional: lista todas las voces
    configurar_voz(voz_index=0, velocidad=145, volumen=1.0)  # <- aquí puedes cambiar el índice de la voz
    jugar()
