<?php

$token = $_GET['token'];

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

$sql = "UPDATE delivrance SET used=1 WHERE token=" . $token;

if ($conn->query($sql) === TRUE) print json_encode(["success" => true]);
else print json_encode(["error" => $conn->error]);


$conn->close();


?>