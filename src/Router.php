<?php

namespace App;

use App\Controller\HomeController;
use App\Controller\ContactController;
use App\Controller\DerouleController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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

        // Détecte le sous-dossier si tu es dans /wedding
        $basePath = '/wedding';
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = trim($uri, '/');

        switch ($uri) {
            case '':
            case 'home':
                $controller = new HomeController();
                $controller->index();
                break;

            case 'contact':
                $controller = new ContactController();
                $controller->index($method);
                break;

            case 'deroule':
                $controller = new DerouleController();
                $controller->index();
                break;

            default:
                http_response_code(404);
                echo $this->twig->render('404.twig', [
                    'title' => 'Page introuvable',
                    'message' => "La page « $uri » n'existe pas."
                ]);
                break;
        }
    }
}
