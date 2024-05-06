<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateHand()
    {
        $cardHand = new CardHand();

        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
    }

    public function testAddCards()
    {
        $cardHand = new CardHand();

        $this->assertEquals($cardHand->getAmountOfCards(), 0);

        $cardHand->addCard(new Card(2, "s", "🂢"));

        $this->assertEquals($cardHand->getAmountOfCards(), 1);

        $cardHand->addCard(new Card(3, "s", "🂣"));

        $this->assertEquals($cardHand->getAmountOfCards(), 2);
    }

    public function testGetHandAsString()
    {
        $cardHand = new CardHand();

        $cardHand->addCard(new Card(2, "s", "🂢"));
        $cardHand->addCard(new Card(3, "s", "🂣"));

        $this->assertIsArray($cardHand->getHandAsString());
        $this->assertEquals($cardHand->getHandAsString()[0], "🂢");
    }

    public function testGetTotalValue()
    {
        $cardHand = new CardHand();

        $this->assertEquals($cardHand->getTotValue(), 0);

        $cardHand->addCard(new Card(2, "s", "🂢"));

        $this->assertEquals($cardHand->getTotValue(), 2);

        $cardHand->addCard(new Card(3, "s", "🂣"));

        $this->assertEquals($cardHand->getTotValue(), 5);
    }

    public function testGetValueAsArr()
    {
        $cardHand = new CardHand();

        $this->assertIsArray($cardHand->getValueAsArr());
        $this->assertEquals(count($cardHand->getValueAsArr()), 0);
        $this->assertEquals(array_sum($cardHand->getValueAsArr()), 0);

        $cardHand->addCard(new Card(2, "s", "🂢"));
        $cardHand->addCard(new Card(3, "s", "🂣"));

        $this->assertEquals(count($cardHand->getValueAsArr()), 2);
        $this->assertEquals(array_sum($cardHand->getValueAsArr()), 5);
    }

}
