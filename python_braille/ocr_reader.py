import pytesseract
import cv2
from pdf2image import convert_from_path
from PIL import Image
import os

# Si es necesario especificar el ejecutable de tesseract
# pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

def ocr_from_image(image_path):
    image = cv2.imread(image_path)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    text = pytesseract.image_to_string(gray, lang='eng')  # Puedes cambiar lang si necesitas otro idioma
    return text

def ocr_from_pdf(pdf_path):
    images = convert_from_path(pdf_path)
    full_text = ""
    for i, img in enumerate(images):
        temp_img_path = f"temp_page_{i}.png"
        img.save(temp_img_path)
        text = ocr_from_image(temp_img_path)
        full_text += text + "\n"
        os.remove(temp_img_path)
    return full_text
