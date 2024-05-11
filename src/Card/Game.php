<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;
/**
 * Class Game
 * 
 * Represents a game of cards between a player and a dealer.
 */
class Game
{
    private object $deck;
    private object $player;
    private object $dealer;

    /**
     * Constructs a new Game instance, initializing the deck, player's hand, and dealer's hand.
     */
    public function __construct(DeckOfCards $deck, Cardhand $player, Cardhand $dealer)
    {
        $this->deck = $deck;
        $this->deck->shuffle();

        $this->player = $player;
        $this->dealer = $dealer;
    }

    /**
     * Retrieves the deck of cards used in the game.
     *
     * @return DeckOfCards The deck of cards.
     */
    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    /**
     * Retrieves the player's hand.
     *
     * @return CardHand The player's hand.
     */
    public function getPlayer(): CardHand
    {
        return $this->player;
    }

    /**
     * Retrieves the dealer's hand.
     *
     * @return CardHand The dealer's hand.
     */
    public function getDealer(): CardHand
    {
        return $this->dealer;
    }

    /**
     * Determines the winner of the game.
     *
     * @return int 1 if the dealer wins, 2 if the player wins.
     */
    public function getWinner(): int
    {
        if ($this->player->getTotValue() > 21) {
            return 1;
        } elseif ($this->dealer->getTotValue() > 21) {
            return 2;
        } elseif ($this->dealer->getTotValue() >= $this->player->getTotValue()) {
            return 1;
        }
        return 2;
    }

}
