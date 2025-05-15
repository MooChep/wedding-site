<?php
// header toujours en haut
include('includes/header.php');

// Récupération de la route propre depuis l’URL
$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request, PHP_URL_PATH);
$request = trim($request, '/'); // ex: "contact", "deroule", ""

// Routes disponibles
switch ($request) {
    case '':
    case 'home':
        include('home.php');
        break;

    case 'contact':
        include('contact.php');
        break;

    case 'deroule':
        include('deroule.php');
        break;

    default:
        http_response_code(404);
        include('404.php');
}

// footer toujours en bas
include('includes/footer.php');
?>
