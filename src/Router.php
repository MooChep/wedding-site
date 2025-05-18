<?php

namespace App;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Router
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function handleRequest(string $uri)
{
    $method = $_SERVER['REQUEST_METHOD'];
    $parsed_uri = str_replace("/", "",$uri);
    var_dump("uri: $parsed_uri");
    switch ($parsed_uri) {
        case '':
        case 'home':
            echo $this->twig->render('home.twig', [
                'title' => 'Accueil',
                'message' => 'Bienvenue sur mon site avec Twig !'
            ]);
            break;

        case 'contact':
            $data = ['title' => 'Contact'];

            if ($method === 'POST') {
                // traitement du formulaire (simple affichage ici)
                $nom = $_POST['nom'] ?? '';
                $email = $_POST['email'] ?? '';
                $message = $_POST['message'] ?? '';

                // Tu pourrais stocker ça en BDD ou envoyer un mail ici
                $data['success'] = "Merci $nom, ton message a bien été envoyé !";
            }

            echo $this->twig->render('contact.twig', $data);
            break;

        case 'deroule':
            echo $this->twig->render('deroule.twig', [
                'title' => 'Déroulé'
            ]);
            break;

        default:
            // http_response_code(404);
            // echo $this->twig->render('404.twig', [
            //     'title' => 'Page introuvable'
            // ]);
            echo $uri;
    }
}

}
