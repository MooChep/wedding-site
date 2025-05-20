<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload Composer
require_once __DIR__ . '/../src/Router.php';      // Appelle le routeur
use App\Router;

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$twig->addGlobal('session', $_SESSION);

$router = new Router();
$router->handleRequest($_SERVER['REQUEST_URI']);