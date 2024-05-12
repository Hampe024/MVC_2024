<?php

namespace App\Card;

use App\Card\Card;
use App\Card\TestScore;

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

    public function getBoard(): array {
        return $this->board;
    }

    public function getCardsForTest(int $x, int $y): array {
        $cards = array();
        if ($x === 5) {
            // get cards horizontally
            foreach ($this->board as $key => $row) {
                foreach ($row as $cell) {
                    if ($key === $y) {
                        $cards[] = $cell;
                    }
                }
            }
        } 
        else {
            // get cards vertically
            foreach ($this->board as $row) {
                foreach ($row as $key => $cell) {
                    if ($key === $x) {
                        $cards[] = $cell;
                    }
                }
            }
        }
        return $cards;
    }

    public function getPoints(int $x, int $y): int
    {
        $cards = $this->getCardsForTest($x, $y);

        foreach ($cards as $card) {
            if (!$card instanceof Card) {
                return 0;
            }
        }

        $score = 0;

        $testScore = new TestScore();

        $testScore->isOnePair($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 1 : "";
        $testScore->isTwoPair($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 3 : "";
        $testScore->isFlush($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 5 : "";
        $testScore->isThreeOfAKind($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 6 : "";
        $testScore->isFullHouse($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 10 : "";
        $testScore->isStraight($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 12 : "";
        $testScore->isFourOfAKind($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 16 : "";
        $testScore->isStraightFlush($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 30 : "";
        $testScore->isRoyalFlush($cards[0], $cards[1], $cards[2], $cards[3], $cards[4]) ? $score = 30 : "";

        return $score;
    }

}