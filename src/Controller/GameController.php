<?php

namespace App\Controller;

use App\Card\Game;
use App\Card\DeckOfCards;
use App\Card\CardHand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    private function getGame(
        SessionInterface $session
    ): Game {
        $game = $session->has('game') ? $session->get('game') : new Game(new DeckOfCards(), new CardHand(), new CardHand());

        $session->set('game', $game);

        return $game;
    }
    private function data(
        SessionInterface $session
    ): array {

        $game = $this->getGame($session);

        $playerPlaying = $session->has('playerPlaying') ? $session->get('playerPlaying') : true;

        $dealerHandArray = [];
        foreach ($game->getDealer()->getCards() as $card) {
            $dealerHandArray[] = [
                'icon' => $card->getAsString(),
                'suite' => $card->getSuite()
            ];
        }

        $data = [
            "playerPlaying" => $playerPlaying,
            "player_hand" => $game->getPlayer(),
            "player_hand_amount" => $game->getPlayer()->getAmountOfCards(),
            "player_hand_value" => $game->getPlayer()->getTotValue(),
            "dealer_hand" => $dealerHandArray,
            "dealer_hand_value" => $game->getDealer()->getValueAsArr(),
        ];

        if ($session->has("ace")) {
            $data["ace"] = $session->get("ace");
        }

        if ($session->has("winner")) {
            $data["winner"] = $session->get("winner");
        }

        return $data;
    }

    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game/intro.html.twig');
    }

    #[Route("/game/play", name: "gamePlay")]
    public function gamePlay(
        SessionInterface $session
    ): Response {
        return $this->render('game/home.html.twig', $this->data($session));
    }

    #[Route("/game/drawCard", name: "gameDrawCard")]
    public function gameDrawCard(
        SessionInterface $session
    ): Response {
        $game = $this->getGame($session);
        $newCard = $game->getDeck()->drawCard();
        if ($newCard->getValue() == -1) {
            // if is ace,
            $session->set("ace", $newCard);
        } else {
            $game->getPlayer()->addCard($newCard);
        }

        $session->set("game", $game);

        return $this->redirectToRoute('gamePlay');
    }

    #[Route("/game/setAce//{value<\d+>}", name: "gameSetAce")]
    public function gameSetAce(
        int $value,
        SessionInterface $session
    ): Response {
        $game = $this->getGame($session);
        $ace = $session->get("ace");
        $session->remove("ace");

        $ace->setValue($value);
        $game->getPlayer()->addCard($ace);

        return $this->render('game/home.html.twig', $this->data($session));
    }

    #[Route("/game/dealerDraw", name: "gameDealerDraw")]
    public function gameDealerDraw(
        SessionInterface $session
    ): Response {
        $game = $this->getGame($session);
        $session->set("playerPlaying", false);
        $game->getDealer()->addCard($game->getDeck()->drawCard());

        while ($game->getDealer()->getTotValue() < 17) {
            // keep playing until value of over 17
            $newCard = $game->getDeck()->drawCard();
            if ($newCard->getValue() == -1) {
                // if is ace, for now dealer always sets ace value to 1
                $newCard->setValue(1);
            }
            $game->getDealer()->addCard($newCard);
        }

        $session->set("winner", $game->getWinner());
        $session->set("game", $game);

        return $this->redirectToRoute('gamePlay');
    }

    #[Route("/game/restart", name: "gameRestart")]
    public function gameRestart(
        SessionInterface $session
    ): Response {
        $session->remove("game");
        $session->remove('playerPlaying');
        $session->remove("winner");
        return $this->redirectToRoute('game');
    }

    #[Route("/game/doc", name: "gameDoc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }
}
