<?php
header('Content-Type: application/json');

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

$sql = "INSERT INTO delivrance ()
VALUES ()";

if ($conn->query($sql) === TRUE)
    echo json_encode(["token" =>  $conn->insert_id]);
else
    echo json_encode(["error" => "Impossible de créer un jeton : " . $sql . "<br>" . $conn->error]);


$conn->close();


?>