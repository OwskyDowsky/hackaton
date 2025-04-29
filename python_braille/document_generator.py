import os
import textwrap
from fpdf import FPDF

def format_braille_text_as_book(braille_text, line_width=50):
    """
    Formatea el texto Braille de manera uniforme.
    """
    paragraphs = braille_text.split('\n')
    formatted_paragraphs = []

    for paragraph in paragraphs:
        paragraph = paragraph.strip()
        if not paragraph:
            formatted_paragraphs.append('')  # Línea vacía para marcar nuevo párrafo
            continue

        wrapped = textwrap.fill(paragraph, width=line_width)
        formatted_paragraphs.append(wrapped)

    return formatted_paragraphs

class BraillePDF(FPDF):
    def __init__(self):
        super().__init__()
        self.set_auto_page_break(auto=True, margin=20)
        self.add_page()

        # ✅ Usar ruta absoluta segura para la fuente
        font_path = os.path.join(os.path.dirname(__file__), 'DejaVuSansCondensed.ttf')

        if not os.path.exists(font_path):
            raise FileNotFoundError(f"La fuente TTF no se encontró en: {font_path}")

        self.add_font('DejaVu', '', font_path, uni=True)
        self.set_font('DejaVu', '', 16)
        self.set_margins(25, 25, 25)

    def add_braille_paragraph(self, text):
        if not text.strip():
            self.ln(10)  # Si es párrafo vacío, salto extra
        else:
            self.multi_cell(0, 10, text, align='L')
            self.ln(5)

def save_text_as_pdf(braille_text, filename="braille_book.pdf"):
    os.makedirs("outputs", exist_ok=True)
    path = os.path.join("outputs", filename)

    formatted_paragraphs = format_braille_text_as_book(braille_text)

    pdf = BraillePDF()

    for paragraph in formatted_paragraphs:
        pdf.add_braille_paragraph(paragraph)

    pdf.output(path)
    print(f"\n[INFO] Documento Braille en PDF guardado exitosamente en: {path}")
