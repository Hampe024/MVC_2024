<?php

namespace App\Dice;

use App\Card\DeckOfCards;
use App\Card\Card;

$joker_cards = [
    "🃟", "🂿"
];

class DeckOfCardsWithJoker extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();

        $this->deck[] = new Card(-1, "black", $joker_cards[0]);
        $this->deck[] = new Card(-1, "white", $joker_cards[1]);
    }
}