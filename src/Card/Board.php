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

    public function getBoard(): array
    {
        return $this->board;
    }

    public function isFull(): bool
    {
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                if (is_null($cell)) {
                    return false;
                }
            }
        }
        return true;
    }

    private function getCardsForTest(int $x, int $y): array
    {
        $cards = array();

        foreach ($this->board as $keyY => $row) {
            foreach ($row as $keyX => $cell) {
                if ($keyY === $y && $x === 5) {
                    $cards[] = $cell;
                }
                if ($keyX === $x && $y === 5) {
                    $cards[] = $cell;
                }
            }
        }
        return $cards;
    }

    public function getPoints(int $x, int $y): int
    {
        $cards = $this->getCardsForTest($x, $y);

        foreach ($cards as $card) {
            if (is_null($card)) {
                return 0;
            }
        }

        $score = 0;

        $testScore = new TestScore();

        $testScore->isOnePair($cards) ? $score = 1 : "";
        $testScore->isTwoPair($cards) ? $score = 3 : "";
        $testScore->isFlush($cards) ? $score = 5 : "";
        $testScore->isThreeOfAKind($cards) ? $score = 6 : "";
        $testScore->isFullHouse($cards) ? $score = 10 : "";
        $testScore->isStraight($cards) ? $score = 12 : "";
        $testScore->isFourOfAKind($cards) ? $score = 16 : "";
        $testScore->isStraightFlush($cards) ? $score = 30 : "";
        $testScore->isRoyalFlush($cards) ? $score = 30 : "";

        return $score;
    }

}