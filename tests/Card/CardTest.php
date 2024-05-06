<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard()
    {
        $card = new Card(2, "s", "🂢");

        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    public function testCardAttributes()
    {
        $card = new Card(2, "s", "🂢");

        $this->assertEquals($card->getValue(), 2);
        $this->assertEquals($card->getAsString(), "🂢");
    }

    public function testChangeCardAttribute()
    {
        $card = new Card(2, "s", "🂢");

        $this->assertEquals($card->getValue(), 2);

        $card->setValue(5);

        $this->assertEquals($card->getValue(), 5);
    }
}
