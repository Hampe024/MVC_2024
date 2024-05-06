<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class DeckOfCardsWithJokerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeck()
    {
        $deck = new DeckOfCardsWithJoker();

        $this->assertInstanceOf("\App\Card\DeckOfCardsWithJoker", $deck);
        $this->assertEquals($deck->getAmountOfCards(), 54);
    }

    public function testHasJokers()
    {
        $deck = new DeckOfCardsWithJoker();

        $jokerBlack = $deck->getDeckAsString()[52];
        $jokerWhite = $deck->getDeckAsString()[53];

        $this->assertEquals($jokerBlack, "🃟");
        $this->assertEquals($jokerWhite, "🂿");
    }

}
