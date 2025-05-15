<?php
require_once("includes/db.php"); // pour établir la connexion
include_once("includes/header.php");
?>

<h1>Réponses aux questions :</h1>

<?php
// Requête vers la table FAQ
$result = $conn->query("SELECT * FROM faq");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($row['question']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['answer'])) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>Aucune question disponible pour le moment.</p>";
}
?>

<?php include_once("includes/footer.php"); ?>
