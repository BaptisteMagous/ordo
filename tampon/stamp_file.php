<?php

require("../fpdf/fpdf.php");
require("../fpdi/autoload.php");
use \setasign\Fpdi\Fpdi;
include '../qrcode/qrlib.php';

$config = json_decode(file_get_contents("config.json"), true);
$file_path = $config["file_dir"] . basename( $_FILES['filename']['name']);

// Requête au site gérant les ordonnances pour reserver un token
$data = json_decode(file_get_contents("http://localhost/ordo/verif/createPrescription.php"), true);
if(array_key_exists('error', $data)){
    echo "Erreur : " . $data["error"];
}

else if(move_uploaded_file($_FILES['filename']['tmp_name'], $file_path))
{

    $link = "http://localhost/ordo/verif/index.html?token=" . $data["token"] . "_";
    // Generation du QRCode
    QRcode::png($link, "qrcode.png");

    // Creation du PDF
    $pdf = new FPDI();
    $pages_count = $pdf->setSourceFile($file_path);

    for($i = 1; $i <= $pages_count; $i++)
    {
        //Charge la page actuelle
        $pdf->AddPage();
        $tplIdx = $pdf->importPage($i);
        $pdf->useTemplate($tplIdx, 0, 0);

        // Ajoute le qrcode sur la page
        $pdf->Image('qrcode.png',10,20,33,0,'', $link);
    }
    // Sauvegarde le pdf
    # $pdf->Output('F', 'stamped_file.pdf');
    // Affiche le pdf dans le navigateur
    $pdf->Output('I', 'stamped_file.pdf');
}
else
{
    echo "There was an error uploading the file " . $_FILES['filename']['name'] . " !";
}



?>