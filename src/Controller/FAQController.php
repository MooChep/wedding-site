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
        $questions = $faqModel->getQuestions();

        echo $this->twig->render('faq.twig', [
            'questions' => $questions,
            'title' => 'Questions fréquentes'
        ]);
    }

        // public function handleFaqEdit(array $get): never
    // {

    // }
    public function addNewQuestion(array $post)
    {
        
        $data = array_merge($post, ["visible"=> "0"]);
        $faqModel = new FAQ();
        $faqModel->addQuestion($data);
        header(header: 'Location: /faq');
exit;
    }
}
