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
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form a Royal Flush, false otherwise.
     */
    public function isRoyalFlush(array $cards): bool
    {
        $values = array_map(function ($card) {
            return $card->getValue() === -1 ? 14 : $card->getValue();
        }, $cards);

        $suits = array_map(function ($card) {
            return $card->getSuite();
        }, $cards);

        sort($values);

        return $values === [10, 11, 12, 13, 14] && count(array_unique($suits)) === 1;
    }

    /**
     * Check if the given cards form a Straight Flush.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form a Straight Flush, false otherwise.
     */
    public function isStraightFlush(array $cards): bool
    {
        return $this->isFlush($cards) && $this->isStraight($cards);
    }

    /**
     * Check if the given cards form Four of a Kind.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form Four of a Kind, false otherwise.
     */
    public function isFourOfAKind(array $cards): bool
    {
        $values = array_map(function ($card) {
            return $card->getValue();
        }, $cards);

        $counts = array_count_values($values);

        return in_array(4, $counts);
    }

    /**
     * Check if the given cards form a Full House.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form a Full House, false otherwise.
     */
    public function isFullHouse(array $cards): bool
    {
        $values = array_map(function ($card) {
            return $card->getValue();
        }, $cards);

        $counts = array_count_values($values);

        return in_array(3, $counts) && in_array(2, $counts);
    }

    /**
     * Check if the given cards form a Flush.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form a Flush, false otherwise.
     */
    public function isFlush(array $cards): bool
    {
        $suits = array_map(function ($card) {
            return $card->getSuite();
        }, $cards);

        return count(array_unique($suits)) === 1;
    }

    /**
     * Check if the given cards form a Straight.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form a Straight, false otherwise.
     */
    public function isStraight(array $cards): bool
    {
        $values = array_map(function ($card) {
            return $card->getValue();
        }, $cards);

        sort($values);

        return
            (count(array_unique($values)) === 5) &&
                (
                    array_sum($values) === 13 ||
                    ($values[0] === -1 && $values[1] === 10) ||
                    (max($values) - min($values) === 4)
                );
    }

    /**
     * Check if the given cards form Three of a Kind.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form Three of a Kind, false otherwise.
     */
    public function isThreeOfAKind(array $cards): bool
    {
        $values = array_map(function ($card) {
            return $card->getValue();
        }, $cards);

        $counts = array_count_values($values);

        return in_array(3, $counts);
    }

    /**
     * Check if the given cards form Two Pair.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form Two Pair, false otherwise.
     */
    public function isTwoPair(array $cards): bool
    {
        $values = array_map(function ($card) {
            return $card->getValue();
        }, $cards);

        $counts = array_count_values($values);

        return count(array_keys($counts, 2)) === 2;
    }

    /**
     * Check if the given cards form One Pair.
     *
     * @param array $cards Array of Card objects.
     * @return bool True if the cards form One Pair, false otherwise.
     */
    public function isOnePair(array $cards): bool
    {
        $values = array_map(function ($card) {
            return $card->getValue();
        }, $cards);

        $counts = array_count_values($values);

        return in_array(2, $counts);
    }
}
