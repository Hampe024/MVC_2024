<?php

namespace App\Card;

class CardHand
{
    protected $cards;

    public function __construct()
    {
        $this->cards = null;
    }

    public function getCards(): int
    {
        return $this->cards;
    }
}