<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class DerouleController
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }

    public function index()
    {
        echo $this->twig->render('deroule.twig', [
            'title' => 'Déroulé'
        ]);
    }
}
