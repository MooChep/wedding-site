<?php include('includes/header.php'); ?>
<h1>Contact</h1>
<form method="POST" action="contact.php">
    <input type="text" name="nom" placeholder="Votre nom" required>
    <input type="email" name="email" placeholder="Votre email" required>
    <textarea name="message" placeholder="Votre message" required></textarea>
    <button type="submit">Envoyer</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p>Merci " . htmlspecialchars($_POST['nom']) . ", votre message a été envoyé.</p>";
}
?>

<?php include('includes/footer.php'); ?>
