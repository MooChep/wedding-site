<?php
$servername = "localhost";
$username = "root"; // ou autre si tu en as défini un
$password = "";     // vide par défaut sous WAMP
$dbname = "wedding_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
