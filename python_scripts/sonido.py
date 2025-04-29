import pygame
import os
import sys
import time

def reproducir_sonido(nombre_archivo):
    BASE_DIR = os.path.dirname(os.path.abspath(__file__))
    sonido_path = os.path.abspath(os.path.join(BASE_DIR, "..", "public", nombre_archivo))
    sonido_path = sonido_path.replace('\\', '/')

    if not os.path.isfile(sonido_path):
        print(f"Sonido no encontrado: {sonido_path}")
        return

    pygame.mixer.init()
    try:
        pygame.mixer.music.load(sonido_path)
        pygame.mixer.music.play()
        while pygame.mixer.music.get_busy():
            time.sleep(0.1)
    except Exception as e:
        print(f"Error reproduciendo sonido: {e}")
    finally:
        pygame.mixer.quit()

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Uso: python sonido.py <archivo_relativo>")
        sys.exit(1)

    reproducir_sonido(sys.argv[1])
