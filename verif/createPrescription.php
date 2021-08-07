<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ordonnances";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    print json_encode([
        "error" => "Erreur interne, la connexion avec la base de donnée a échoué",
        "log" => $conn->connect_error
    ]);
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO delivrance ()
VALUES ()";

if ($conn->query($sql) === TRUE)
    print json_encode(["token" =>  $conn->insert_id]);
else
    print json_encode(["error" => "Impossible de créer un jeton : " . $sql . "<br>" . $conn->error]);


$conn->close();


?>