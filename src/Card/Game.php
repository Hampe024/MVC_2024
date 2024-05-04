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
        if ($this->player->getTotalValue() > 21) {
            return 1;
        }
        else if ($this->dealer->getTotalValue() > 21) {
            return 2;
        }
        else if ($this->dealer->getTotalValue() >= $this->player->getTotalValue()) {
            return 1;
        }
        return 2;
    }

}