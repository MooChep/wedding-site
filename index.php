<?php
// header toujours en haut
include_once('includes/header.php');

// Récupération de la route propre depuis l’URL
$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request, PHP_URL_PATH);
$request = trim($request, '/'); // ex: "contact", "deroule", ""

// Routes disponibles + tests d'existence
$page = $request ?: 'home';
$file = "$page.php";

if (file_exists($file)) {
    include($file);
} else {
    http_response_code(404);
    include('404.php');
}
// footer toujours en bas
include_once('includes/footer.php');
?>
