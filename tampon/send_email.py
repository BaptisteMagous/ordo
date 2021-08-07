import smtplib, ssl

from email import encoders
from email.mime.base import MIMEBase
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

def send_email(email_to, file, email_from = "ordonnance.test@gmail.com", subject = "Votre ordonnance", body = "Bonjour, voici votre ordonnance"):

   # strip leading path from file name to avoid
   # directory traversal attacks

    # == WRITE EMAIL == #
    # Create a multipart message and set headers
    mail = MIMEMultipart()
    mail["From"] = email_from
    mail["To"] = email_to
    mail["Subject"] = subject

    attachment = MIMEBase("application", "octet-stream")
    attachment.set_payload(file.read())

    # Encode file in ASCII characters to send by email
    encoders.encode_base64(attachment)

    # Add header as key/value pair to attachment part
    attachment.add_header(
        "Content-Disposition",
        f"attachment; filename= Ordonnance.pdf",
    )

    # Add attachment to message and convert message to string
    mail.attach(MIMEText(body, "plain"))
    mail.attach(attachment)


    # == SEND EMAIL == #
    port = 465  # For SSL
    # Create a secure SSL context
    context = ssl.create_default_context()
    with smtplib.SMTP_SSL("smtp.gmail.com", port, context=context) as server:
        server.login(email_from, "0rd0nn4ncE")
        server.sendmail(email_from, email_to, mail.as_string())

    return True


