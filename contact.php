<?php include('includes/header.php'); ?>
<h1>Contact</h1>
<form method="POST" action="contact.php">
    <input type="text" name="nom" placeholder="Votre nom" required>
    <input type="text" name="prenom" placeholder="Votre prénom" required>
    <input type="email" name="email" placeholder="Votre email" required>
    <textarea name="message" placeholder="Votre message" required></textarea>
    <button type="submit">Envoyer</button>
</form>

<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO contact (nom, prenom, email) VALUES (?, ?, ?)');
    $stmt->execute([
        $_POST['nom'],
        $_POST['email'],
        $_POST['message']
    ]);
    echo "<p>Message enregistré !</p>";
}
?>

<?php include('includes/footer.php'); ?>
