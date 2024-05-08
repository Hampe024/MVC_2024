<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    private function getDeckAndHand(
        SessionInterface $session
    ): array {
        $deck = $session->has('deck') ? $session->get('deck') : new DeckOfCards();
        $hand = $session->has('hand') ? $session->get('hand') : new CardHand();

        $session->set('deck', $deck);
        $session->set('hand', $hand);

        return [$deck, $hand];
    }

    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "cardDeck")]
    public function cardDeck(
        SessionInterface $session
    ): Response {

        [$deck, $hand] = $this->getDeckAndHand($session);

        $data = [
            'hand' => $hand,
            'handAmount' => $hand->getAmountOfCards(),
            'deck' => $deck,
            'deckAmount' => $deck->getAmountOfCards()
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "cardDeckShuffle")]
    public function cardDeckShuffle(
        SessionInterface $session
    ): Response {

        [$deck, $hand] = $this->getDeckAndHand($session);

        $deck->shuffle();

        $data = [
            'hand' => $hand,
            'handAmount' => $hand->getAmountOfCards(),
            'deck' => $deck,
            'deckAmount' => $deck->getAmountOfCards()
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "cardDeckDrawOne")]
    public function cardDeckDrawOne(
    ): Response {
        return $this->redirectToRoute('cardDeckDraw', ['num' => 1]);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "cardDeckDraw")]
    public function cardDeckDraw(
        int $num,
        SessionInterface $session
    ): Response {

        [$deck, $hand] = $this->getDeckAndHand($session);

        for ($i = 0; $i < $num; $i++) {
            $hand->addCard($deck->drawCard());
        }

        $data = [
            'hand' => $hand,
            'handAmount' => $hand->getAmountOfCards(),
            'deck' => $deck,
            'deckAmount' => $deck->getAmountOfCards()
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/reset", name: "cardDeckReset")]
    public function cardDeckReset(
        SessionInterface $session
    ): Response {
        $session->remove('deck');
        $session->remove('hand');

        return $this->redirectToRoute('cardDeck');
    }
}
