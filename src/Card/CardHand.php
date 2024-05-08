<?php
/*
 * This file contains the class CardHand
 *
 */

namespace App\Card;

/*
 * This is the CardHand class
 *
 * It is resposible for holding and handeling
 * a player or dealers cards
 */
class CardHand
{
    /**
     * @var array Array to store cards in the hand.
     */
    private array $cards = array();

    /**
     * Adds a card to the hand.
     *
     * @param Card $card The card to add to the hand.
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * Returns the hand as an array of strings with the card icons.
     *
     * @return array<int, string> An array of strings representing each card in the hand.
     */
    public function getHandAsString(): array
    {
        $cards = array();

        foreach ($this->cards as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    /**
     * Returns the amount of cards in the hand.
     *
     * @return int The number of cards in the hand.
     */
    public function getAmountOfCards(): int
    {
        return count($this->cards);
    }

    /**
     * Returns the cards in the hand.
     *
     * @return array The number cards in the hand.
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Calculates and returns the total value of all cards in the hand.
     *
     * @return int The total value of all cards in the hand.
     */
    public function getTotValue(): int
    {
        $value = 0;
        foreach ($this->cards as $card) {
            $value += $card->getValue();
        }
        return $value;
    }

    /**
     * Return the values of all cards in the hand as an array.
     *
     * @return array<int, int> An array containing the values of all cards in the hand as integers.
     */
    public function getValueAsArr(): array
    {
        $value = array();

        foreach ($this->cards as $card) {
            $value[] = $card->getValue();
        }
        return $value;
    }
}
