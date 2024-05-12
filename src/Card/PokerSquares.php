<?php

namespace App\Card;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\Board;

class PokerSquares
{
    private DeckOfCards $deck;
    private Board $board;
    private Card $nextCard;

    public function __construct(DeckOfCards $deck, Board $board)
    {
        $this->deck = $deck;
        $this->deck->shuffle();

        $this->board = $board;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function setNextCard(): void
    {
        if (!isset($this->nextCard)) {
            $this->nextCard = $this->deck->drawCard();
        }
    }

    public function getNextCard(): Card
    {
        return $this->nextCard;
    }

    public function unsetNextCard(): void
    {
        unset($this->nextCard);
    }
}