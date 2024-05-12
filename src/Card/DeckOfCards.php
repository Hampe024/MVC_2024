<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    protected array $deck = array();

    public function __construct()
    {
        $suits = [
            "s", "h", "d", "c"
        ];
        $icons = [
            ["🂡", "🂱", "🃁", "🃑"], // Ace of Spades, Ace of Hearts, Ace of Diamonds, Ace of Clubs
            ["🂢", "🂲", "🃂", "🃒"], // Two of Spades, Two of Hearts, Two of Diamonds, Two of Clubs
            ["🂣", "🂳", "🃃", "🃓"], // Three of Spades, Three of Hearts, Three of Diamonds, Three of Clubs
            ["🂤", "🂴", "🃄", "🃔"], // Four of Spades, Four of Hearts, Four of Diamonds, Four of Clubs
            ["🂥", "🂵", "🃅", "🃕"], // Five of Spades, Five of Hearts, Five of Diamonds, Five of Clubs
            ["🂦", "🂶", "🃆", "🃖"], // Six of Spades, Six of Hearts, Six of Diamonds, Six of Clubs
            ["🂧", "🂷", "🃇", "🃗"], // Seven of Spades, Seven of Hearts, Seven of Diamonds, Seven of Clubs
            ["🂨", "🂸", "🃈", "🃘"], // Eight of Spades, Eight of Hearts, Eight of Diamonds, Eight of Clubs
            ["🂩", "🂹", "🃉", "🃙"], // Nine of Spades, Nine of Hearts, Nine of Diamonds, Nine of Clubs
            ["🂪", "🂺", "🃊", "🃚"], // Ten of Spades, Ten of Hearts, Ten of Diamonds, Ten of Clubs
            ["🂫", "🂻", "🃋", "🃛"], // Jack of Spades, Jack of Hearts, Jack of Diamonds, Jack of Clubs
            ["🂭", "🂽", "🃍", "🃝"], // Queen of Spades, Queen of Hearts, Queen of Diamonds, Queen of Clubs
            ["🂮", "🂾", "🃎", "🃞"], // King of Spades, King of Hearts, King of Diamonds, King of Clubs
        ];
        // $iconBackside = "🂠";

        for ($i = 0; $i < 13; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $value = $i + 1;
                if ($value == 1) {
                    $value = -1; // change value of ace to -1
                }
                $this->deck[] = new Card(
                    $value,
                    $suits[$j],
                    $icons[$i][$j]
                );
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function getAmountOfCards(): int
    {
        return count($this->deck);
    }

    public function drawCard(): object
    {
        return array_shift($this->deck);
    }

    public function getDeck(): array
    {
        return $this->deck;
    }


    public function getDeckAsString(): array
    {
        $cards = array();

        foreach ($this->deck as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }
}
