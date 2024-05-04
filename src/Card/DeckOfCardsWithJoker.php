<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\Card;

class DeckOfCardsWithJoker extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();

        $joker_cards = [
            "🃟", "🂿"
        ];
        $this->deck[] = new Card(-2, "black", $joker_cards[0]);
        $this->deck[] = new Card(-2, "white", $joker_cards[1]);
    }
}
