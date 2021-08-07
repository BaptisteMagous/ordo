<?php

$token = $_GET['token'];

$config = json_decode(file_get_contents("config.json"), true);

// Create connection
$conn = new mysqli($config["servername"], $config["username"], $config["password"], $config["dbname"]);

// Check connection
if ($conn->connect_error) {
    // On error :
    print json_encode([
        "error" => "Erreur interne, la connexion avec la base de donnée a échoué",
        "log" => $conn->connect_error
    ]);
    // Stop the execution
    die("Connection failed: " . $conn->connect_error);
}

//Met à jour l'état de l'ordonnance
if ($conn->query("UPDATE delivrance SET used=1 WHERE token=" . $token))
    print json_encode(["success" => true]);
//Si la requête SQL a échoué, retourne une erreur
else
    print json_encode(["error" => $conn->error]);



$conn->close();


?>