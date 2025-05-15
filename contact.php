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
$conn = new mysqli('localhost', 'root', '', 'wedding_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include('includes/db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    $stmt = $conn->prepare("INSERT INTO contact_requests (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
}

?>

<?php include('includes/footer.php'); ?>
