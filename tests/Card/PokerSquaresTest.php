<?php

namespace App\Card;

use App\Card\PokerSquares;
use App\Card\DeckOfCards;
use App\Card\Board;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PokerSquares.
 */
class PokerSquaresTest extends TestCase
{
    public function testDeckIsShuffled(): void 
    {
        $pokerSquares = new PokerSquares(new DeckOfCards(), new Board());

        $nonShuffledDeck = new DeckOfCards();

        $this->assertNotEquals($pokerSquares->getDeck(), $nonShuffledDeck);
        // these could theoretically be the same, but MAN is that unlikely...
    }

    public function testGetBoard(): void 
    {
        $pokerSquares = new PokerSquares(new DeckOfCards(), new Board());

        $this->assertInstanceOf("\App\Card\Board", $pokerSquares->getBoard());
    }

    public function testSetNextCard(): void
    {
        $pokerSquares = new PokerSquares(new DeckOfCards(), new Board());

        $nextCard = $pokerSquares->getNextCard();

        $this->assertNull($nextCard);
        $this->assertEquals($pokerSquares->getDeck()->getAmountOfCards(), 52);

        $pokerSquares->setNextCard();
        $nextCard = $pokerSquares->getNextCard();

        $this->assertNotNull($nextCard);
        $this->assertInstanceOf("\App\Card\Card", $nextCard);
        $this->assertEquals($pokerSquares->getDeck()->getAmountOfCards(), 51);

    }

    public function testUnsetNextCard(): void
    {
        $pokerSquares = new PokerSquares(new DeckOfCards(), new Board());

        $pokerSquares->setNextCard();

        $this->assertNotNull($pokerSquares->getNextCard());

        $pokerSquares->unsetNextCard();

        $this->assertNull($pokerSquares->getNextCard());

    }
}