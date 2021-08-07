import os

from PIL import Image
from docx2pdf import convert

def convertToPdf(fileitem):
    format = fileitem.filename.split(".")[-1] #Get the last element of a list
    if format == "pdf":
        open('tmp/temp.pdf', 'wb').write(fileitem.file.read())
    elif format == "docx":
        open('tmp/temp.docx', 'wb').write(fileitem.file.read())
        convert('tmp/temp.docx', 'tmp/temp.pdf')
    elif format == "png":
        open('tmp/temp.png', 'wb').write(fileitem.file.read())
        img = Image.open('tmp/temp.png')
        img = img.convert("RGB")
        img.save('tmp/temp.pdf')
    elif format == "jpeg":
        open('tmp/temp.jpeg', 'wb').write(fileitem.file.read())
        img = Image.open('tmp/temp.jpeg')
        img = img.convert("RGB")
        img.save('tmp/temp.pdf')
    else:
        return False

    return open('tmp/temp.pdf', 'rb')