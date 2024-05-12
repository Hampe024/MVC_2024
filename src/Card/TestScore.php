<?php

namespace App\Card;

use App\Card\Card;

/**
 * Class TestScore
 * Provides methods for testing score of cards.
 */
class TestScore
{
    /**
     * Check if the given cards form a Royal Flush.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form a Royal Flush, false otherwise.
     */
    public static function isRoyalFlush(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $suits = [$card1->getSuite(), $card2->getSuite(), $card3->getSuite(), $card4->getSuite(), $card5->getSuite()];
        sort($values);
        return $values === [10, 11, 12, 13, 14] && count(array_unique($suits)) === 1;
    }

    /**
     * Check if the given cards form a Straight Flush.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form a Straight Flush, false otherwise.
     */
    public static function isStraightFlush(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        return self::isFlush($card1, $card2, $card3, $card4, $card5) && self::isStraight($card1, $card2, $card3, $card4, $card5);
    }

    /**
     * Check if the given cards form Four of a Kind.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form Four of a Kind, false otherwise.
     */
    public static function isFourOfAKind(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(4, $counts);
    }

    /**
     * Check if the given cards form a Full House.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form a Full House, false otherwise.
     */
    public static function isFullHouse(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(3, $counts) && in_array(2, $counts);
    }

    /**
     * Check if the given cards form a Flush.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form a Flush, false otherwise.
     */
    public static function isFlush(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $suits = [$card1->getSuite(), $card2->getSuite(), $card3->getSuite(), $card4->getSuite(), $card5->getSuite()];
        return count(array_unique($suits)) === 1;
    }

    /**
     * Check if the given cards form a Straight.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form a Straight, false otherwise.
     */
    public static function isStraight(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        sort($values);
        return max($values) - min($values) === 4 && count(array_unique($values)) === 5;
    }

    /**
     * Check if the given cards form Three of a Kind.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form Three of a Kind, false otherwise.
     */
    public static function isThreeOfAKind(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(3, $counts);
    }

    /**
     * Check if the given cards form Two Pair.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form Two Pair, false otherwise.
     */
    public static function isTwoPair(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return count(array_keys($counts, 2)) === 2;
    }

    /**
     * Check if the given cards form One Pair.
     *
     * @param Card $card1 The first card.
     * @param Card $card2 The second card.
     * @param Card $card3 The third card.
     * @param Card $card4 The fourth card.
     * @param Card $card5 The fifth card.
     * @return bool True if the cards form One Pair, false otherwise.
     */
    public static function isOnePair(Card $card1, Card $card2, Card $card3, Card $card4, Card $card5): bool
    {
        $values = [$card1->getValue(), $card2->getValue(), $card3->getValue(), $card4->getValue(), $card5->getValue()];
        $counts = array_count_values($values);
        return in_array(2, $counts);
    }
}