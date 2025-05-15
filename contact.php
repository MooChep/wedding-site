<?php require_once("includes/db.php"); ?>
<?php include("includes/header.php"); ?>

<p class="content-box">Merci de bien vouloir répondre à ces quelques questions pour nous aider à organiser
    notre mariage. Nous sommes impatients de vous retrouver !</p>
<p class="comment">Toutes les informations resteront privées et seront consultées uniquement par Camille et Ilan.</p>

<form method="POST" action="contact.php">
    <label>Prénom :</label>
    <input type="text" name="prenom" placeholder="Camille" required>

    <label>Nom :</label>
    <input type="text" name="nom" placeholder="Sanchez" required>

    <label>Accompagnants :</label>
<div id="accompagnants-container"></div>
<button type="button" onclick="ajouterAccompagnant()">+ Ajouter un accompagnant</button><br><br>

     <label>Quand serez-vous parmi nous ?</label>
    <select name="presence" required>
        <option value="" disabled selected>Choisissez une option</option>
        <option value="4">Tout le samedi</option>
        <option value="5">Samedi et dimanche</option>
        <option value="2">Seulement au vin d'honneur</option>
        <option value="3">Seulement au repas</option>
        <option value="1">Impossible d'être parmi vous</option>
    </select>    

    <label>Musique pour danser :</label>
    <input type="text" name="musique" placeholder="Exemple: Allumer le feu">


    <button type="submit">Envoyer</button>
</form>

<script>
let accompagnantIndex = 0;

function ajouterAccompagnant() {
    const container = document.getElementById("accompagnants-container");

    const div = document.createElement("div");
    div.className = "accompagnant";
    div.innerHTML = `
        <input type="text" name="accompagnants[${accompagnantIndex}][prenom]" placeholder="Prénom" required>
        <input type="text" name="accompagnants[${accompagnantIndex}][nom]" placeholder="Nom" required>
        <button type="button" onclick="this.parentElement.remove()">Supprimer l'accompagnant</button>
        <br>
    `;
    container.appendChild(div);
    accompagnantIndex++;
}
</script>


<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $presence = intval($_POST['presence']);
    $musique = $_POST['musique'] ?? null;

    // 1. Insérer RSVP
    $stmt_rsvp = $conn->prepare("INSERT INTO RSVP (date_rsvp) VALUES (NOW())");
    $stmt_rsvp->execute();
    $id_rsvp = $conn->insert_id;

    // 2. Insérer la personne principale
    $stmt_pers = $conn->prepare("INSERT INTO personne (nom, prenom, id_presence, id_rsvp) VALUES (?, ?, ?, ?)");
    $stmt_pers->bind_param("ssii", $nom, $prenom, $presence, $id_rsvp);
    $stmt_pers->execute();
    $id_personne = $conn->insert_id;

    // 3. Insérer les accompagnants s’il y en a
    if (!empty($_POST['accompagnants']) && is_array($_POST['accompagnants'])) {
        foreach ($_POST['accompagnants'] as $acc) {
            $a_nom = $acc['nom'];
            $a_prenom = $acc['prenom'];
            $stmt_pers->bind_param("ssii", $a_nom, $a_prenom, $presence, $id_rsvp);
            $stmt_pers->execute();
        }
    }

    // 4. Insérer la musique (si fournie)
    if (!empty($musique)) {
        $stmt_music = $conn->prepare("INSERT INTO musique (nom, id_personne) VALUES (?, ?)");
        $stmt_music->bind_param("si", $musique, $id_personne);
        $stmt_music->execute();
    }

    echo "<p>Merci, votre réponse a été enregistrée !</p>";
}
?>

<?php include("includes/footer.php"); ?>
