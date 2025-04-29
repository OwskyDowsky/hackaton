# Braille para Español, Inglés, Portugués (simplificado para ahora)
braille_alphabet = {
    'a': '⠁', 'b': '⠃', 'c': '⠉',
    'd': '⠙', 'e': '⠑', 'f': '⠋',
    'g': '⠛', 'h': '⠓', 'i': '⠊',
    'j': '⠚', 'k': '⠅', 'l': '⠇',
    'm': '⠍', 'n': '⠝', 'o': '⠕',
    'p': '⠏', 'q': '⠟', 'r': '⠗',
    's': '⠎', 't': '⠞', 'u': '⠥',
    'v': '⠧', 'w': '⠺', 'x': '⠭',
    'y': '⠽', 'z': '⠵',
    'á': '⠷', 'é': '⠿', 'í': '⠮', 'ó': '⠾', 'ú': '⠬',
    'ã': '⠻', 'õ': '⠽',
    'ç': '⠯',
    ' ': ' ', '\n': '\n', '.': '⠲', ',': '⠂', '"': '⠶'
}

def translate_to_braille(text, language='es'):
    """
    Traduce texto al Braille básico según idioma (por ahora base es igual).
    """
    text = text.lower()
    braille_text = ''
    for char in text:
        braille_text += braille_alphabet.get(char, '')  # Si no encuentra, no pone nada
    return braille_text
