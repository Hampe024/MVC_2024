<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game extends AbstractController
{
    private function getGame(
        SessionInterface $session
    ): array {
        $deck = $session->has('deck') ? $session->get('deck') : new DeckOfCards();
        $hand = $session->has('hand') ? $session->get('hand') : new CardHand();

        $session->set('deck', $deck);
        $session->set('hand', $hand);

        return [$deck, $hand];
    }

    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('card/home.html.twig');
    }
    #[Route("/game/doc", name: "gameDoc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }
}
