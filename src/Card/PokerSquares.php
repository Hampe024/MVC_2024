<?php

namespace App\Card;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\Board;

class PokerSquares
{
    private DeckOfCards $deck;
    private Board $board;

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
}