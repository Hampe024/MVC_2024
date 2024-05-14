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

    private function getHighscore(
        SessionInterface $session
    ): array {
        $highscore = $session->has('highscore') ? $session->get('highscore') : [58];

        $session->set('highscore', $highscore);

        return $highscore;
    }

    #[Route("/proj", name: "proj")]
    public function proj(
        SessionInterface $session
    ): Response {
        $highscore = $this->getHighscore($session);

        $pokerSquares = $this->getPokerSquares($session);
        $pokerSquares->setNextCard();

        $data = [
            "pokerSquares" => $pokerSquares,
            "highscore" => $highscore
        ];

        return $this->render('proj/home.html.twig', $data);
    }

    #[Route("/proj/setCard/{x}/{y}", name: "projSetCard")]
    public function projSetCard(
        SessionInterface $session,
        int $x,
        int $y
    ): Response {
        $pokerSquares = $this->getPokerSquares($session);

        $nextCard = $pokerSquares->getNextCard();
        if (!is_null($nextCard)) {
            $pokerSquares->getBoard()->setCard($nextCard, $x, $y);
            $pokerSquares->unsetNextCard();
        }

        return $this->redirectToRoute('proj');
    }

    #[Route("/proj/reset", name: "projReset")]
    public function projReset(
        SessionInterface $session,
    ): Response {
        $session->remove("pokerSquares");
        return $this->redirectToRoute('proj');
    }

    #[Route("/proj/setHighscore/{score}", name: "projSetHighscore")]
    public function projSetHighscore(
        SessionInterface $session,
        int $score
    ): Response {
        $highscore = $this->getHighscore($session);

        $highscore[] = $score;
        rsort($highscore);

        $session->set('highscore', $highscore);

        return $this->redirectToRoute('proj');
    }

    #[Route("/proj/about", name: "projAbout")]
    public function projAbout(
    ): Response {
        return $this->render('proj/about.html.twig');
    }
}
