<?php

require("../fpdf183/fpdf.php");

$uploaddir = '/var/www/uploads/';
$uploadfile = $uploaddir . basename( $_FILES['filename']['name']);

if(move_uploaded_file($_FILES['filename']['tmp_name'], $uploadfile))
{
    echo "The file has been uploaded successfully";
}
else
{
    echo "There was an error uploading the file " . $_FILES['filename']['name'] . " !";
}

?>