import qrcode
from io import FileIO
from PIL import Image

from PyPDF4 import PdfFileReader, PdfFileWriter


def stamp(pdfstream, data):
    input = PdfFileReader(pdfstream)
    output = PdfFileWriter()

    qr_code = qrcode.make(data)
    qr_code.save("tmp/qrcode.png")

    qr_image = Image.open("tmp/qrcode.png")
    qr_image.save(r'tmp/qrcode.pdf')
    stamp = PdfFileReader(open("tmp/qrcode.pdf", "rb"))

    for p in range(0, input.numPages):
        page = input.getPage(p)
        page.mergeScaledPage(stamp.getPage(0), 0.2)
        output.addPage(page)

    stream = FileIO("tmp/temp_stamped.pdf", "w")
    output.write(stream)
    return open("tmp/temp_stamped.pdf", "rb")