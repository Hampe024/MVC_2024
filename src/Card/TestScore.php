<?php

use App\Card\Card;

class TestScore
{
    public static function isRoyalFlush(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $suits = [$card1->getSuite(), $card2->getSuite(), $card3->getSuite(), $card4->getSuite(), $card5->getSuite()];
        sort($values);
        return $values === [10, 11, 12, 13, 14] && count(array_unique($suits)) === 1;
    }

    public static function isStraightFlush(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        return self::isFlush($card1, $card2, $card3, $card4, $card5) && self::isStraight($card1, $card2, $card3, $card4, $card5);
    }

    public static function isFourOfAKind(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(4, $counts);
    }

    public static function isFullHouse(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(3, $counts) && in_array(2, $counts);
    }

    public static function isFlush(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $suits = [$card1->getSuite(), $card2->getSuite(), $card3->getSuite(), $card4->getSuite(), $card5->getSuite()];
        return count(array_unique($suits)) === 1;
    }

    public static function isStraight(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        sort($values);
        return max($values) - min($values) === 4 && count(array_unique($values)) === 5;
    }

    public static function isThreeOfAKind(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(3, $counts);
    }

    public static function isTwoPair(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return count(array_keys($counts, 2)) === 2;
    }

    public static function isOnePair(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(2, $counts);
    }
}