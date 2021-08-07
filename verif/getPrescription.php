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

$result = $conn->query("SELECT used FROM delivrance WHERE token=" . $token);


//Si on a trouvé l'ordonnance
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        // On regarde si l'ordonnance a été délivrée (attribut "used" à 1)
        $delivered = $row["used"] == "1";
    }
    print json_encode([
        "delivered" => $delivered,
        "token" => $token
    ]);
}

//Si on a pas trouvé l'ordonnance
else {
    print json_encode([
        "error" => "Cette ordonnance est introuvable",
        "token" => $token
    ]);

}

$conn->close();


?>