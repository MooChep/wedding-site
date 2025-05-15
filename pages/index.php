<?php include('includes/header.php');

$page = $_GET['page'] ?? 'home';

switch ($page) {
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
        include('404.php');}

include('includes/footer.php');
