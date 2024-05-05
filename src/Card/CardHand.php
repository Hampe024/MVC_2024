<?php

namespace App\Card;

class CardHand
{
    protected array $cards = array();

    public function __construct()
    {
    }

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    public function getHandAsString(): array
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

    public function getTotValue(): int
    {
        $value = 0;
        foreach ($this->cards as $card) {
            $value += $card->getValue();
        }
        return $value;
    }

    public function getValueAsArr(): array
    {
        $value = array();

        foreach ($this->cards as $card) {
            $value[] = $card->getValue();
        }
        return $value;
    }
}
