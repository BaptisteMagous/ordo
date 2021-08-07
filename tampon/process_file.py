#!C:\Program Files\WindowsApps\PythonSoftwareFoundation.Python.3.8_3.8.2288.0_x64__qbz5n2kfra8p0\python3.8.exe
# -*- coding: utf-8 -*-
import sys
import codecs

import requests

sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

# Import modules for CGI handling
import cgi, os
import cgitb; cgitb.enable()
import io


from send_email import send_email
from convert import convertToPdf
from stamper import stamp

# Create instance of FieldStorage
form = cgi.FieldStorage()

# Get data from fields
fileitem = form['filename']
email_to = form.getvalue('email')



print("Content-type:text/html\r\n\r\n")
print(f"""
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ordonnance</title>

    <meta name="description" content="Maquette projet Ordonnance">
    <meta name="author" content="Baptiste MAGOUS">
    <meta name="keywords" content="ordonnance">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <h1>Maquette Ordonnance</h1>
    </div>
    <div class="error">""")
token = requests.get('http://localhost/ordo/verif/createPrescription.php').json()["token"]
qr_code = f"http://localhost/ordo/verif/?token={token}_"
pdf = convertToPdf(fileitem)
if pdf == False:
    print('Format non autorisé')

else:
    stamped_pdf = stamp(pdf, qr_code)
    if send_email(email_to, stamped_pdf):
        print('</div><div class="form"> <p>E-mail envoyé avec succès !<br>'
              '<a href="http://localhost/ordo/tampon/">Revenir à l\'acceuil</a></p>')
        print(f'</div><div class="qrcode"> <a href="{qr_code}"> <img src="qrcode.png" style="width: 100%;"> </a>')


print(f"""
    </div>
</body>
</html>
""")