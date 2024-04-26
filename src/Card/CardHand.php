<?php

namespace App\Card;

class CardHand
{
    protected $cards = array();

    public function __construct()
    {
    }

    public function addCard($card)
    {
        $this->cards[] = $card;
    }

    public function getHandAsString()
    {
        $cards = array();

        foreach ($this->cards as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    public function getAmountOfCards(): int
    {
        return count($this->cards);
    }
}