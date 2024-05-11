<?php

namespace App\Controller;

use App\Card\PokerSquares;
use App\Card\DeckOfCards;
use App\Card\Board;
use App\Card\Card;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerSquaresController extends AbstractController
{
    private function getPokerSquares(
        SessionInterface $session
    ): PokerSquares {
        $pokerSquares = $session->has('pokerSquares') ? $session->get('pokerSquares') : new PokerSquares(new DeckOfCards(), new Board());

        $session->set('pokerSquares', $pokerSquares);

        return $pokerSquares;
    }

    #[Route("/proj", name: "proj")]
    public function proj(
        SessionInterface $session
    ): Response
    {
        return $this->render('proj/home.html.twig', ["pokerSquares" => $this->getPokerSquares($session)]);
    }

    #[Route("/proj/setCard", name: "projSetCard")]
    public function projSetCard(
        SessionInterface $session
    ): Response
    {
        $pokerSquares = $this->getPokerSquares($session);

        $pokerSquares->getBoard()->setCard(new Card(2, "h", "🂶"), 0, 3);

        return $this->redirectToRoute('proj');
    }
}