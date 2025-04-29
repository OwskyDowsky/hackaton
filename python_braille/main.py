from ocr_reader import ocr_from_image, ocr_from_pdf
from braille_translator import translate_to_braille
from document_generator import save_text_as_pdf
from translator import translate_text
from voice_reader import read_text
import sys
import os

def main():
    if len(sys.argv) < 4:
        print("Error de uso. Se esperaba: python main.py archivo modo idioma")
        return

    file_path = sys.argv[1]
    mode = sys.argv[2]
    target_language = sys.argv[3]

    if not os.path.exists(file_path):
        print("Error: el archivo no existe:", file_path)
        return

    if file_path.lower().endswith(('.png', '.jpg', '.jpeg')):
        original_text = ocr_from_image(file_path)
    elif file_path.lower().endswith('.pdf'):
        original_text = ocr_from_pdf(file_path)
    else:
        print("Error: formato de archivo no soportado:", file_path)
        return

    # Mostrar texto original
    print("\nTexto original extraído:")
    print("-" * 50)
    print(original_text[:500])  # Mostrar solo primeros 500 caracteres para evitar errores
    print("-" * 50)

    # Traducción
    if target_language != 'es':
        print("\nTraduciendo texto...")
        translated_text = translate_text(original_text, target_language)
    else:
        translated_text = original_text

    # Mostrar texto traducido
    print("\nTexto traducido:")
    print("-" * 50)
    print(translated_text[:500])  # Mostrar solo primeros 500 caracteres para evitar errores
    print("-" * 50)

    if mode == 'voice':
        print("\nListo para lectura de voz.")
        # IMPORTANTE: Laravel maneja la voz en navegador, no ejecutar pyttsx3 aquí
        # Opcional: podrías guardar el texto para que Laravel lo lea
        output_path = os.path.join('storage', 'app', 'public', 'voice_outputs', 'output_text.txt')
        os.makedirs(os.path.dirname(output_path), exist_ok=True)
        with open(output_path, 'w', encoding='utf-8') as f:
            f.write(translated_text)
        print("✅ Texto para lectura guardado en:", output_path)

    elif mode == 'braille':
        print("\nConvirtiendo a Braille...")
        braille_text = translate_to_braille(translated_text)

        # Guardar Braille en PDF y en TXT
        output_pdf = os.path.join('storage', 'app', 'public', 'braille_outputs', f"{os.path.splitext(os.path.basename(file_path))[0]}_braille_{target_language}.pdf")
        output_txt = os.path.join('storage', 'app', 'public', 'braille_outputs', f"{os.path.splitext(os.path.basename(file_path))[0]}_braille_{target_language}.txt")
        
        os.makedirs(os.path.dirname(output_pdf), exist_ok=True)

        # Guardar como TXT (opcional)
        with open(output_txt, 'w', encoding='utf-8') as f:
            f.write(braille_text)

        # Guardar como PDF
        save_text_as_pdf(braille_text, output_pdf)

        print("✅ Documento Braille guardado en PDF:", output_pdf)
        print("✅ Documento Braille guardado en TXT:", output_txt)
        
    else:
        print("Error: modo inválido:", mode)

if __name__ == "__main__":
    main()
