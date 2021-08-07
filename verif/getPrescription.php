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

$sql = "SELECT used FROM delivrance WHERE token=" . $token;
$result = $conn->query($sql);
while( $row = $result->fetch_assoc()){
    $delivered = $row["used"] == "1";
}

if ($result->num_rows > 0) {
    print json_encode([
        "delivered" => $delivered,
        "token" => $token
    ]);
} else {
    print json_encode([
        "error" => "Cette ordonnance est introuvable",
        "token" => $token
    ]);

}

$conn->close();


?>