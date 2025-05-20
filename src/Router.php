<?php

namespace App;

use App\Controller\HomeController;
use App\Controller\RSVPController;
use App\Controller\DerouleController;
use App\Controller\FAQController;
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

    $basePath = '/wedding';
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }

    $uri = trim(string: $uri, characters: '/');

    switch ($uri) {
        case '':
        case 'home':
            $controller = new HomeController();
            $controller->index();
            break;

        case 'rsvp':
            $controller = new RSVPController();
            
            if ($method == 'POST') {
                $controller->submitForm(postData: $_POST);
            } else {
                $controller->index();
            }
            break;

        case 'deroule':
            $controller = new DerouleController();
            $controller->index();
            break;

        case 'faq':
            $controller = new FAQController();
            $controller->index();
            break;
            
        case 'admin':
            $controller = new \App\Controller\AdminController();
            $controller->index();
        case 'admin/rsvp':
            $controller = new \App\Controller\AdminController();
            $controller->showRsvpStatus();
            break;
                
        case 'admin/faq':
            $controller = new \App\Controller\AdminController();
            if ($method == 'GET') {
                $controller->showFAQModeration();
            } else {
                $controller->handleFAQ($_GET);
            }
            break;
        case 'admin/faq/add':
            $controller = new \App\Controller\AdminController();
            $controller->addNewQuestion($_POST);
        default:  
            http_response_code(response_code: 404);
            echo $this->twig->render('404.twig', [
                'title' => 'Page introuvable',
                'message' => "La page « $uri » n'existe pas."
            ]);
            break;
    }
}

}
