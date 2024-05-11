<?php

namespace App\Controller;

use App\Card\Game;
use App\Card\DeckOfCards;
use App\Card\CardHand;

use App\Repository\LibraryRepository;
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

    #[Route("/api/game", name: "apiGame")]
    public function apiGame(
        SessionInterface $session
    ): Response {

        $game = $session->has('game') ? $session->get('game') : new Game(new DeckOfCards(), new CardHand(), new CardHand());

        $playerPlaying = $session->has('playerPlaying') ? $session->get('playerPlaying') : true;

        $data = [
            "playerPlaying" => $playerPlaying,
            "player_hand" => $game->getPlayer()->getHandAsString(),
            "player_hand_amount" => $game->getPlayer()->getAmountOfCards(),
            "player_hand_value" => $game->getPlayer()->getValueAsArr(),
            "dealer_hand" => $game->getDealer()->getHandAsString(),
            "dealer_hand_amount" => $game->getDealer()->getAmountOfCards(),
            "dealer_hand_value" => $game->getDealer()->getValueAsArr(),
        ];

        if ($session->has("ace")) {
            $data["ace"] = $session->get("ace")->getAsString();
        }

        if ($session->has("winner")) {
            $data["winner"] = $session->get("winner");
        }

        return new JsonResponse($data);
    }

    #[Route('/api/library/books', name: 'apiLibraryBooks')]
    public function apiLibraryBooks(
        LibraryRepository $libraryRepository
    ): Response {
        $response = $this->json($libraryRepository->findAll());
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/library/book/{isbn}', name: 'apiLibraryBookByISBN')]
    public function apiLibraryBookByISBN(
        LibraryRepository $libraryRepository,
        string $isbn
    ): Response {
        $book = $libraryRepository->findOneByISBN($isbn);

        if (count($book) === 0) {
            return new JsonResponse(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonResponse = new JsonResponse($book);
        $jsonResponse->setEncodingOptions(JSON_PRETTY_PRINT);

        return $jsonResponse;
    }
}
