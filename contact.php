<?php
require_once("includes/db.php"); // adapte le chemin si nécessaire
?>
<?php
include("includes/header.php") 
?>
<h1>Contact</h1>
<form method="POST" action="contact.php">
    <input type="text" name="nom" placeholder="Votre nom" required>
    <input type="text" name="prenom" placeholder="Votre prénom" required>
    <input type="email" name="email" placeholder="Votre email" required>
    <textarea name="message" placeholder="Votre message" required></textarea>
    <button type="submit">Envoyer</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    
    $stmt = $conn->prepare("INSERT INTO contact_requests (nom, prenom, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $prenom, $email, $message);
    if ($stmt->execute()) {
        echo "Message envoyé avec succès !";
    } else {
        echo "Erreur : " . $stmt->error;
    }
}

?>

<?php
include("includes/footer.php") 
?>