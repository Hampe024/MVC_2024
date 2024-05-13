<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeck()
    {
        $deck = new DeckOfCards();

        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        $this->assertEquals($deck->getAmountOfCards(), 52);
    }

    public function testGetAmountOfCards()
    {
        $deck = new DeckOfCards();

        $this->assertEquals($deck->getAmountOfCards(), 52);

        $deck->drawCard();

        $this->assertEquals($deck->getAmountOfCards(), 51);
    }

    public function testDrawCard()
    {
        $deck = new DeckOfCards();

        $card = $deck->drawCard();

        $this->assertInstanceOf("\App\Card\Card", $card);
        $this->assertEquals($card, new Card(-1, "s", "🂡"));
    }

    public function testShuffle()
    {
        $deck = new DeckOfCards();

        $deckBeforeShuffle = $deck->getDeckAsString();
        $deck->shuffle();
        $deckAfterShuffle = $deck->getDeckAsString();
        $this->assertNotEquals($deckBeforeShuffle, $deckAfterShuffle);
        // these could theoretically be the same, but MAN is that unlikely...
    }

    public function testGetDeckAsString()
    {
        $deck = new DeckOfCards();

        $this->assertIsArray($deck->getDeckAsString());
        $this->assertEquals(count($deck->getDeckAsString()), 52);
        $this->assertIsString($deck->getDeckAsString()[0]);
    }

    public function testGetDeck()
    {
        $deck = new DeckOfCards();

        $this->assertIsArray($deck->getDeck());
        $this->assertEquals(count($deck->getDeck()), 52);
    }
}
