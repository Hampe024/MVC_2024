<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Api extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('misc/api.html.twig');
    }
    #[Route("/api/quote", name: "quote")]
    public function quote(): Response
    {
        $quotes = [
            [
                "quote" => "To be, or not to be, that is the question.",
                "author" => "William Shakespeare",
            ],
            [
                "quote" => "The best time to plant a tree was 20 years ago. The second best time is now.",
                "author" => "Chinese Proverb",
            ],
            [
                "quote" => "The best way to predict your future is to create it.",
                "author" => "Abraham Lincoln",
            ],
        ];
        $chosenQuote = $quotes[random_int(0, 2)];

        $data = [
            $chosenQuote,
            "date" => date("Y/m/d"),
            "time" => date("h:i:sa"),
        ];

        return new JsonResponse($data);
    }
}