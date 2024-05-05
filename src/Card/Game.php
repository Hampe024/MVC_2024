<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class Game
{
    public $deck;
    public $player;
    public $dealer;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->deck->shuffle();

        $this->player = new Cardhand();
        $this->dealer = new Cardhand();
    }

    public function getWinner(): int
    {
        // return 1 if dealer win, 2 if player
        if ($this->player->getTotValue() > 21) {
            return 1;
        }
        else if ($this->dealer->getTotValue() > 21) {
            return 2;
        }
        else if ($this->dealer->getTotValue() >= $this->player->getTotValue()) {
            return 1;
        }
        return 2;
    }

}