from deep_translator import GoogleTranslator

def split_text(text, max_chars=5000):
    """
    Divide el texto en partes más pequeñas que el límite permitido por la API.
    """
    parts = []
    while len(text) > max_chars:
        split_point = text.rfind('.', 0, max_chars)  # buscar el último punto antes del límite
        if split_point == -1:
            split_point = max_chars
        parts.append(text[:split_point + 1].strip())
        text = text[split_point + 1:].strip()
    if text:
        parts.append(text)
    return parts

def translate_text(text, target_language='en'):
    """
    Traduce el texto completo aunque supere 5000 caracteres.
    """
    try:
        text_parts = split_text(text)
        translated_parts = []

        for part in text_parts:
            translated = GoogleTranslator(source='auto', target=target_language).translate(part)
            translated_parts.append(translated)
        
        return ' '.join(translated_parts)

    except Exception as e:
        print(f"❌ Error al traducir: {e}")
        return text
