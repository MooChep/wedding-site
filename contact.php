<?php
require_once("includes/db.php"); // adapte le chemin si nécessaire
?>
<?php
include("includes/header.php") 
?>

    <p class="content-box">Merci de bien vouloir répondre à ces quelques questions pour nous aider à organiser
         notre mariage, nous sommes impatient de vous retrouver ! </p><br> <p class="comment"> Toutes les informations renseignées dans ce 
         formulaire resteront privées et seront visionnée uniquement par Camille et Ilan</p>
    <form method="POST" action="contact.php" >
      <label>Prénom :</label>
      <input type="text" name="prenom" placeholder="Camille" required>

      <label>Nom :</label>
      <input type="text" name="nom" placeholder="Sanchez" required>

      <label>Nombre de personnes :</label>
      <input type="number" name="nb_personnes" min="1" placeholder="Combien que vous êtes ?" required>

      <label>Nom des accompagnants :</label>
      <input type="text" name="accompagnants" placeholder= "Identité de vos +1">
      <!-- surveymonkey inspi -->
      <label>Serez-vous présent ?</label>
      <input type="checkbox" id="vin" name="presence" value="vin">
      <label for="vin">Seulement au vin d'honneur</label>
      <input type="checkbox" id="repas" name="presence" value="repas">
      <label for="repas">Seulement au repas</label>
      <input type="checkbox" id="les deux" name="presence" value="les deux">
      <label for="les deux">Toute la journée !</label>
      <input type="checkbox" id="brunch" name="presence" value="brunch">
      <label for="brunch">Au brunch du lendemain</label>
      <input type="checkbox" id="non" name="presence" value="non">
      <label for="non">Malheureusement, non !</label><br>

      <label>Titre et auteur de la musique qui vous fait danser jusqu'au bout de la nuit :</label>
      <input type="text" name="musique" placeholder="Exemple: Allumer le feu">

      <label>Si vous souhaitez participer à l'organisation du mariage (animations, discours...), n'hésitez pas à nous le faire savoir !</Label>
      <input type="text" name="participation" placeholder="Bah oui bien sur j'adorerais organiser un jeu sur le caca">

      <button type="submit">Envoyer</button>
    </form>
  </main>
  <!-- https://me-qr.com/fr/qr-code-generator/qr -->
<!-- QR Code -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $nb_personnes = $_POST['nb_personnes'];
$presence = '';
if (isset($_POST['presence']) && is_array($_POST['presence'])) {
    $presence = implode(", ", $_POST['presence']);
}
$musique = isset($_POST['musique']) ? $_POST['musique'] : '';
$participation = isset($_POST['participation']) ? $_POST['participation'] : '';

$stmt = $conn->prepare("INSERT INTO contact_requests (nom, prenom, nb_personnes, presence, musique, participation) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisss", $nom, $prenom, $nb_personnes, $presence, $musique, $participation);

    if ($stmt->execute()) {
        echo "<p>Message envoyé avec succès !</p>";
    } else {
        echo "<p>Erreur : " . $stmt->error . "</p>";
    }
}
?>
<script>
document.querySelector("form").addEventListener("submit", function(e) {
    const prenom = document.querySelector('[name="prenom"]');
    const nom = document.querySelector('[name="nom"]');
    const nbPersonnes = document.querySelector('[name="nb_personnes"]');
    const presence = document.querySelectorAll('[name="presence"]:checked');

    if (!prenom.value.trim() || !nom.value.trim() || !nbPersonnes.value.trim()) {
        alert("Merci de remplir tous les champs obligatoires !");
        e.preventDefault(); // Empêche l'envoi
        return;
    }

    if (presence.length === 0) {
        alert("Merci d'indiquer votre présence !");
        e.preventDefault();
        return;
    }

    // Tu peux ajouter ici d'autres vérifs si besoin
});
</script>


<?php
include("includes/footer.php") 
?>