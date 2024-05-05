<?php

namespace App\Controller;

use App\Card\Game;

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
        $game = $session->has('game') ? $session->get('game') : new Game();

        $session->set('game', $game);

        return $game;
    }
    private function Data(
        SessionInterface $session
    ): array {

        $game = $this->getGame($session);

        $player_playing = $session->has('player_playing') ? $session->get('player_playing') : True;

        $data = [
            "player_playing" => $player_playing,
            "player_hand" => $game->player->getHandAsString(),
            "player_hand_amount" => $game->player->getAmountOfCards(),
            "player_hand_value" => $game->player->getTotValue(),
            "dealer_hand" => $game->dealer->getHandAsString(),
            "dealer_hand_value" => $game->dealer->getValueAsArr(),
        ];

        if ($session->has("ace")) {
            $data["ace"] = $session->get("ace")->getAsString();
        }

        if ($session->has("winner")) {
            $data["winner"] = $session->get("winner");
        }

        return $data;
    }

    #[Route("/game", name: "game")]
    public function game(
        SessionInterface $session
    ): Response
    {
        return $this->render('game/intro.html.twig');
    }

    #[Route("/game/play", name: "gamePlay")]
    public function gamePlay(
        SessionInterface $session
    ): Response
    {

        $game = $this->getGame($session);

        return $this->render('game/home.html.twig', $this->data($session));
    }

    #[Route("/game/drawCard", name: "gameDrawCard")]
    public function gameDrawCard(
        SessionInterface $session
    ): Response
    {
        $game = $this->getGame($session);
        $newCard = $game->deck->drawCard();
        if ($newCard->getValue() == -1) {
            // if is ace, 
            $session->set("ace", $newCard);
        } 
        else {
            $game->player->addCard($newCard);
        }

        $session->set("game", $game);

        return $this->redirectToRoute('gamePlay');
    }

    #[Route("/game/setAce//{value<\d+>}", name: "gameSetAce")]
    public function gameSetAce(
        int $value,
        SessionInterface $session
    ): Response
    {
        $game = $this->getGame($session);
        $ace = $session->get("ace");
        $session->remove("ace");

        $ace->setValue($value);
        $game->player->addCard($ace);

        return $this->render('game/home.html.twig', $this->data($session));
    }

    #[Route("/game/dealerDraw", name: "gameDealerDraw")]
    public function gameDealerDraw(
        SessionInterface $session
    ): Response
    {
        $game = $this->getGame($session);
        $session->set("player_playing", false);
        $game->dealer->addCard($game->deck->drawCard());
        
        while ($game->dealer->getTotValue() < 17) {
            // keep playing until value of over 17
            $newCard = $game->deck->drawCard();
            if ($newCard->getValue() == -1) {
                // if is ace, for now dealer always sets ace value to 1
                $newCard->setValue(1);
            }
            $game->dealer->addCard($newCard);
        }

        $session->set("winner", $game->getWinner());
        $session->set("game", $game);

        return $this->redirectToRoute('gamePlay');
    }

    #[Route("/game/restart", name: "gameRestart")]
    public function gameRestart(
        SessionInterface $session
    ): Response
    {
        $session->remove("game");
        $session->remove('player_playing');
        $session->remove("winner");
        return $this->redirectToRoute('game');
    }

    #[Route("/game/doc", name: "gameDoc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }
}
