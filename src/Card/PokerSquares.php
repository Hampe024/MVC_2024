<?php

namespace App\Card;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\Board;

/**
 * Class PokerSquares
 *
 * Represents a game of Poker Squares.
 */
class PokerSquares
{
    /**
     * @var DeckOfCards The deck of cards used in the game.
     */
    private DeckOfCards $deck;
    /**
     * @var Board The game board where cards are placed.
     */
    private Board $board;
    /**
     * @var Card|null The next card to be played.
     */
    private ?Card $nextCard;

    /**
     * PokerSquares constructor.
     *
     * @param DeckOfCards $deck The deck of cards to be used.
     * @param Board $board The game board to be used.
     */
    public function __construct(DeckOfCards $deck, Board $board)
    {
        $this->deck = $deck;
        $this->deck->shuffle();

        $this->board = $board;
    }

    /**
     * Get the game board.
     *
     * @return Board The game board.
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Set the next card to be played.
     * If a next card is not set, draw a card from the deck.
     */
    public function setNextCard(): void
    {
        if (!isset($this->nextCard)) {
            $this->nextCard = $this->deck->drawCard();
        }
    }

    /**
     * Get the next card to be played.
     *
     * @return Card|null The next card, or null if no card is set.
     */
    public function getNextCard(): ?Card
    {
        return $this->nextCard ?? null;
    }

    /**
     * Unset the next card.
     */
    public function unsetNextCard(): void
    {
        unset($this->nextCard);
    }

    /**
     * Get the deck of cards.
     *
     * @return DeckOfCards The deck of cards.
     */
    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }
}
