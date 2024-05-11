<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Game;
use App\Card\DeckOfCards;
use App\Card\CardHand;

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
        $game = new Game(new DeckOfCards(), new CardHand(), new CardHand());

        $this->assertInstanceOf("\App\Card\Game", $game);
        $this->assertInstanceOf("\App\Card\DeckOfCards", $game->getDeck());
        $this->assertInstanceOf("\App\Card\CardHand", $game->getPlayer());
        $this->assertInstanceOf("\App\Card\CardHand", $game->getDealer());
    }

    public function testgetWinner()
    {
        $game = new Game(new DeckOfCards(), new CardHand(), new CardHand());

        $this->assertEquals($game->getWinner(), 1);
        // same value

        $game->getPlayer()->addCard(new Card(20, "s", ""));
        $this->assertEquals($game->getWinner(), 2);
        // player has higher

        $game->getDealer()->addCard(new Card(21, "s", ""));
        $this->assertEquals($game->getWinner(), 1);
        // dealer has higher

        $game->getDealer()->addCard(new Card(2, "s", ""));
        $this->assertEquals($game->getWinner(), 2);
        // dealer have too high

        $game->getPlayer()->addCard(new Card(2, "s", ""));
        $this->assertEquals($game->getWinner(), 1);
        // both has too high

        $game->getPlayer()->addCard(new Card(1, "s", ""));
        $this->assertEquals($game->getWinner(), 1);
        // both have too high and equal

    }
}
