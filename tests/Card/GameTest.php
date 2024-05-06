<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class GameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGame()
    {
        $game = new Game();

        $this->assertInstanceOf("\App\Card\Game", $game);
        $this->assertInstanceOf("\App\Card\DeckOfCards", $game->deck);
        $this->assertInstanceOf("\App\Card\CardHand", $game->player);
        $this->assertInstanceOf("\App\Card\CardHand", $game->dealer);
    }

    public function testgetWinner()
    {
        $game = new Game();

        $this->assertEquals($game->getWinner(), 1);
        // same value

        $game->player->addCard(new Card(20, "s", ""));
        $this->assertEquals($game->getWinner(), 2);
        // player has higher

        $game->dealer->addCard(new Card(21, "s", ""));
        $this->assertEquals($game->getWinner(), 1);
        // dealer has higher

        $game->dealer->addCard(new Card(2, "s", ""));
        $this->assertEquals($game->getWinner(), 2);
        // dealer have too high

        $game->player->addCard(new Card(2, "s", ""));
        $this->assertEquals($game->getWinner(), 1);
        // both has too high

        $game->player->addCard(new Card(1, "s", ""));
        $this->assertEquals($game->getWinner(), 1);
        // both have too high and equal
        
    }
}