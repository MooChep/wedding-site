    <?php require_once("includes/db.php"); ?>
    <?php include("includes/header.php"); ?>

    <div class="text-center mb-4">
        <h2>Confirme ta présence ✉️</h2>
        <p class="lead">Merci de bien vouloir répondre à ces quelques questions pour nous aider à organiser notre mariage.<br> Toutes les informations resteront privées et seront consultées uniquement par Camille et Ilan.</p>
    </div>

    <form method="POST" action="contact.php" class="row g-3 w-100">
        <div class="col-md-6">
            <label class="form-label">Prénom</label>
            <input type="text" class="form-control" name="prenom" placeholder="Camille" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" placeholder="Sanchez" required>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Accompagnants</label>
                <div id="accompagnants-container" class="d-flex flex-column gap-2"></div>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="ajouterAccompagnant()">+ Ajouter un accompagnant</button>
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Quand serez-vous parmi nous ?</label>
            <select name="presence" class="form-select" style="width: 55vw" required>
                <option value="" disabled selected>Choisissez une option</option>
                <option value="4">Tout le samedi</option>
                <option value="5">Samedi et dimanche</option>
                <option value="2">Seulement au vin d'honneur</option>
                <option value="3">Seulement au repas</option>
                <option value="1">Impossible d'être parmi vous</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Musique pour danser (facultatif)</label>
            <input type="text" class="form-control" style="width: 55vw" name="musique" placeholder="Exemple: Allumer le feu">
        </div>


        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success btn-lg mt-3">Envoyer la réponse</button>
        </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $presence = intval($_POST['presence']);
        $musique = $_POST['musique'] ?? null;

        $stmt_rsvp = $conn->prepare("INSERT INTO RSVP (date_rsvp) VALUES (NOW())");
        $stmt_rsvp->execute();
        $id_rsvp = $conn->insert_id;

        $stmt_pers = $conn->prepare("INSERT INTO personne (nom, prenom, id_presence, id_rsvp) VALUES (?, ?, ?, ?)");
        $stmt_pers->bind_param("ssii", $nom, $prenom, $presence, $id_rsvp);
        $stmt_pers->execute();
        $id_personne = $conn->insert_id;

        if (!empty($_POST['accompagnants']) && is_array($_POST['accompagnants'])) {
            foreach ($_POST['accompagnants'] as $acc) {
                $a_nom = $acc['nom'];
                $a_prenom = $acc['prenom'];
                $stmt_pers->bind_param("ssii", $a_nom, $a_prenom, $presence, $id_rsvp);
                $stmt_pers->execute();
            }
        }

        if (!empty($musique)) {
            $stmt_music = $conn->prepare("INSERT INTO musique (nom, id_personne) VALUES (?, ?)");
            $stmt_music->bind_param("si", $musique, $id_personne);
            $stmt_music->execute();
        }

        echo '<div class="alert alert-success mt-4 text-center" role="alert">Merci, votre réponse a été enregistrée !</div>';
    }
    ?>

<script>
let accompagnantIndex = 0;

function ajouterAccompagnant() {
    const container = document.getElementById("accompagnants-container");

    const div = document.createElement("div");
    div.class = "col-12"
    div.innerHTML = `
        <input type="text" class="form-control" name="accompagnants[${accompagnantIndex}][prenom]" placeholder="Prénom" required>
        <input type="text" class="form-control" name="accompagnants[${accompagnantIndex}][nom]" placeholder="Nom" required>
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">❌</button>
    `;
    container.appendChild(div);
    accompagnantIndex++;
}
</script>

    <?php include("includes/footer.php"); ?>
</div>
