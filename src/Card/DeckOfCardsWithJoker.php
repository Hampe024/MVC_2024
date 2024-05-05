<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\Card;

class DeckOfCardsWithJoker extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();

        $jokerCards = [
            "🃟", "🂿"
        ];
        $this->deck[] = new Card(-2, "black", $jokerCards[0]);
        $this->deck[] = new Card(-2, "white", $jokerCards[1]);
    }
}
