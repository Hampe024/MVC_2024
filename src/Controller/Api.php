<?php

namespace App\Controller;

use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    private function getDeck(
        SessionInterface $session
    ): DeckOfCards {
        $deck = $session->has('deck') ? $session->get('deck') : new DeckOfCards();

        $session->set('deck', $deck);

        return $deck;
    }

    #[Route("/api/deck", name: "apiDeck")]
    public function apiDeck(
        SessionInterface $session
    ): Response {
        $deck = $this->getDeck($session);
        $data = [
            'deck' => $deck->getDeckAsString(),
        ];

        return new JsonResponse($data);
    }

    #[Route("/api/deck/shuffle", name: "apiDeckShuffle")]
    public function apiDeckShuffle(
        SessionInterface $session
    ): Response {
        $deck = $this->getDeck($session);

        $deck->shuffle();

        $session->set('deck', $deck);

        $data = [
            'deck' => $deck->getDeckAsString(),
        ];

        return new JsonResponse($data);
    }

    #[Route("/api/deck/draw", name: "apiDeckDrawOne")]
    public function apiDeckDrawOne(
    ): Response {
        return $this->redirectToRoute('apiDeckDraw', ['num' => 1]);
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "apiDeckDraw")]
    public function apiDeckDraw(
        int $num,
        SessionInterface $session
    ): Response {

        $deck = $this->getDeck($session);

        $drawnCards = array();

        for ($i = 0; $i < $num; $i++) {
            $drawnCards[] = $deck->drawCard()->getAsString();
        }

        $data = [
            'cards' => $drawnCards
        ];
        return new JsonResponse($data);
    }
}
