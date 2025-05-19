<?php
namespace App\Controller;

use App\Model\Personne;
use App\Model\RSVP;
use App\Model\Presence;
use App\Model\Musique;
use App\Database;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RSVPController
{
    private Environment $twig;
    private Personne $personneModel;
    private RSVP $rsvpModel;
    private Presence $presenceModel;
    private Musique $musiqueModel;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);

        $this->personneModel = new Personne(Database::getConnection());
        $this->rsvpModel = new RSVP();
        $this->presenceModel = new Presence();
        $this->musiqueModel = new Musique();
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->submitForm($_POST);
        } else {
            $this->showForm();
        }
    }


    // Affichage du formulaire RSVP
    public function showForm()
    {
        $personnes = $this->personneModel->findAll();
        $presences = $this->presenceModel->findAll();

        echo $this->twig->render('rsvp.twig', [
            'title' => 'RSVP',
            'personnes' => $personnes,
            'presences' => $presences
        ]);
    }

    // Traitement du formulaire de soumission RSVP
    public function submitForm(array $postData)
{
    $nom = $postData['nom'];
    $prenom = $postData['prenom'];
    $presence = isset($postData['presence']) ? intval($postData['presence']) : null;
    $musique = $postData['musique'] ?? null;
    $accompagnants = $postData['accompagnants'] ?? [];
    $id_rsvp = $this->personneModel->insertRSVP();

    $id_personne = $this->personneModel->insertPersonne($nom, $prenom, $presence, $id_rsvp);

    foreach ($accompagnants as $acc) {
        if (!empty($acc['nom']) && !empty($acc['prenom'])) {
            $this->personneModel->insertPersonne($acc['nom'], $acc['prenom'], $presence, $id_rsvp);
        }
    }

    if (!empty($musique)) {
        $this->personneModel->insertMusique($musique, $id_personne);
    }

    echo $this->twig->render('rsvp.twig', ['success' => 'Merci, votre réponse a été enregistrée !']);
}
}