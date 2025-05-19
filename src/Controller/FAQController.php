<?php

namespace App\Controller;

use App\Model\FAQ;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class FAQController {
    private Environment $twig;

    public function __construct()
    {        
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }


    public function index()
    {
        $faqModel = new FAQ();
        $questions = $faqModel->getVisibleQuestions();

        echo $this->twig->render('faq.twig', [
            'questions' => $questions,
            'title' => 'Questions fréquentes'
        ]);
    }
}
