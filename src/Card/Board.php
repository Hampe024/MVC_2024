<?php

namespace App\Card;

use Exception;

use App\Card\Card;
use App\Card\TestScore;

/**
 * Class Board
 *
 * Represents the game board for placing cards and calculating points.
 */
Class Board
{
    /** 
     * @var array|null[][]
     */
    private array $board;

    /**
     * Board constructor.
     *
     * Initializes the game board with null values.
     */
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

    /**
     * Set a card at the specified coordinates on the board.
     *
     * @param Card $card The card to be placed.
     * @param int $x The x-coordinate.
     * @param int $y The y-coordinate. NOTE: starts from top
     *
     * @throws Exception If the specified position on the board is already occupied.
     */
    public function setCard(Card $card, int $x, int $y): void
    {
        if (is_null($this->board[$y][$x])) {
            $this->board[$y][$x] = $card;
        } else {
            throw new Exception();
        }
    }

    /**
     * Get the current state of the game board.
     *
     * @return array The game board.
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * Check if the game board is full.
     *
     * @return bool Returns true if the board is full, otherwise false.
     */
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

    /**
     * Get the cards present on the specified row and column.
     *
     * @param int $x The x-coordinate.
     * @param int $y The y-coordinate. NOTE: starts from top
     *
     * @return array The cards present on the specified row and column.
     */
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

    /**
     * Calculate the points for the specified row and column.
     *
     * @param int $x The x-coordinate.
     * @param int $y The y-coordinate. NOTE: starts from top
     *
     * @return int The calculated points.
     */
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