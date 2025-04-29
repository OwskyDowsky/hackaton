from ocr_reader import ocr_from_image, ocr_from_pdf
from braille_translator import translate_to_braille
from document_generator import save_text_as_pdf
from translator import translate_text
from voice_reader import read_text
import os
import argparse
from fpdf import FPDF

def main():
    parser = argparse.ArgumentParser(description="Lector Braille")
    parser.add_argument('--file', required=True, help="Ruta del archivo (imagen o PDF)")
    parser.add_argument('--mode', required=True, choices=['voice', 'braille'], help="Modo: 'voice' o 'braille'")
    parser.add_argument('--lang', required=True, choices=['es', 'en', 'pt'], help="Idioma de destino: es, en o pt")
    parser.add_argument('--output', required=True, help="Nombre de archivo de salida (sin extensión)")

    args = parser.parse_args()

    file_path = args.file
    mode = args.mode
    target_language = args.lang
    output_name = args.output

    if not os.path.exists(file_path):
        print("[ERROR] Archivo no encontrado.")
        return

    # Detectar si es PDF o imagen
    if file_path.lower().endswith('.pdf'):
        original_text = ocr_from_pdf(file_path)
    else:
        original_text = ocr_from_image(file_path)

    # Traducción
    translated_text = original_text
    if target_language != 'es':
        print("Traduciendo texto...")
        translated_text = translate_text(original_text, target_language)

    # Modo de salida
    if mode == 'voice':
        print("Leyendo texto en voz...")
        read_text(translated_text)

    elif mode == 'braille':
        print("Traduciendo a Braille...")
        braille_text = translate_to_braille(translated_text)
        print("Guardando en PDF...")
        save_text_as_pdf(braille_text, f"{output_name}_{target_language}.pdf")
        print("¡Documento Braille generado!")

if __name__ == "__main__":
    main()
