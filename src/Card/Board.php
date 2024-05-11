<?php

namespace App\Card;

use App\Card\Card;

Class Board
{
    private array $board;

    public function __construct()
    {
        $this->board = [
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
        ];
    }

    public function setCard(Card $card, int $x, int $y): void
    {
        if (is_null($this->board[$y][$x])) {
            $this->board[$y][$x] = $card;
        } else {
            throw Exception;
        }
    }

    public function print(): array
    {
        $returnBoard = [];

        foreach ($this->board as $row) {
            $rowData = [];
            foreach ($row as $cell) {
                if ($cell instanceof Card) {
                    $rowData[] = $cell->getAsString();
                } else {
                    $rowData[] = $cell;
                }
            }
            $returnBoard[] = $rowData;
        }

        return $returnBoard;
    }
}