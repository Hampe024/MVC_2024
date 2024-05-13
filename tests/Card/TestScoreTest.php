<?php

namespace App\Card;

use App\Card\TestScore;
use App\Card\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class TestScore.
 */
class TestScoreTest extends TestCase
{
    public function testIsRoyalFlush(): void
    {

        $testScore = new TestScore();

        $testValidRoyalFlush = [
            new Card(10, "test", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(12, "test", "irrelevant"),
            new Card(13, "test", "irrelevant"),
            new Card(14, "test", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isRoyalFlush($testValidRoyalFlush));

        $testNotValidValues = [
            new Card(10, "test", "irrelevant"),
            new Card(12, "test", "irrelevant"),
            new Card(12, "test", "irrelevant"),
            new Card(13, "test", "irrelevant"),
            new Card(14, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isRoyalFlush($testNotValidValues));

        $testNotSameSuite = [
            new Card(10, "test", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(12, "notTest", "irrelevant"),
            new Card(13, "test", "irrelevant"),
            new Card(14, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isRoyalFlush($testNotSameSuite));
    }

    public function testIsStraightFlush(): void
    {

        $testScore = new TestScore();

        $testStraightFlush1 = [
            new Card(10, "test", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(12, "test", "irrelevant"),
            new Card(13, "test", "irrelevant"),
            new Card(-1, "test", "irrelevant"),
        ];
        $testStraightFlush2 = [
            new Card(-1, "test", "irrelevant"),
            new Card(2, "test", "irrelevant"),
            new Card(3, "test", "irrelevant"),
            new Card(4, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isStraightFlush($testStraightFlush1));
        $this->assertNotFalse($testScore->isStraightFlush($testStraightFlush2));

        $testStraightNotFlush = [
            new Card(-1, "test", "irrelevant"),
            new Card(2, "test", "irrelevant"),
            new Card(3, "notTest", "irrelevant"),
            new Card(4, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isStraightFlush($testStraightNotFlush));

        $testNotStraightFlush = [
            new Card(-1, "test", "irrelevant"),
            new Card(2, "test", "irrelevant"),
            new Card(4, "test", "irrelevant"),
            new Card(4, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isStraightFlush($testNotStraightFlush));
    }

    public function testIsFourOfAKind(): void
    {

        $testScore = new TestScore();

        $testFourOfAKind1 = [
            new Card(10, "test", "irrelevant"),
            new Card(10, "notTest", "irrelevant"),
            new Card(10, "probablyNotTest", "irrelevant"),
            new Card(10, "forSureNotest", "irrelevant"),
            new Card(11, "test", "irrelevant"),
        ];
        $testFourOfAKind2 = [
            new Card(1, "test", "irrelevant"),
            new Card(2, "notTest", "irrelevant"),
            new Card(1, "notTest", "irrelevant"),
            new Card(1, "probablyNotTest", "irrelevant"),
            new Card(1, "forSureNotest", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isFourOfAKind($testFourOfAKind1));
        $this->assertNotFalse($testScore->isFourOfAKind($testFourOfAKind2));

        $testOnlyThreeOfAKind = [
            new Card(1, "test", "irrelevant"),
            new Card(2, "notTest", "irrelevant"),
            new Card(1, "notTest", "irrelevant"),
            new Card(1, "probablyNotTest", "irrelevant"),
            new Card(5, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isFourOfAKind($testOnlyThreeOfAKind));
    }

    public function testIsFullHouse(): void
    {

        $testScore = new TestScore();

        $testFullHouse1 = [
            new Card(10, "test", "irrelevant"),
            new Card(10, "notTest", "irrelevant"),
            new Card(10, "probablyNotTest", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(11, "notTest", "irrelevant"),
        ];
        $testFullHouse2 = [
            new Card(5, "test", "irrelevant"),
            new Card(13, "test", "irrelevant"),
            new Card(5, "notTest", "irrelevant"),
            new Card(5, "probablyNotTest", "irrelevant"),
            new Card(13, "notTest", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isFullHouse($testFullHouse1));
        $this->assertNotFalse($testScore->isFullHouse($testFullHouse2));

        $testNotFullHouse = [
            new Card(5, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(5, "notTest", "irrelevant"),
            new Card(5, "probablyNotTest", "irrelevant"),
            new Card(13, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isFullHouse($testNotFullHouse));
    }

    public function testIsFlush(): void
    {

        $testScore = new TestScore();

        $testFlush1 = [
            new Card(2, "test", "irrelevant"),
            new Card(8, "test", "irrelevant"),
            new Card(3, "test", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
        ];
        $testFlush2 = [
            new Card(1, "otherTest", "irrelevant"),
            new Card(2, "otherTest", "irrelevant"),
            new Card(3, "otherTest", "irrelevant"),
            new Card(4, "otherTest", "irrelevant"),
            new Card(5, "otherTest", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isFlush($testFlush1));
        $this->assertNotFalse($testScore->isFlush($testFlush2));

        $testNotFlush = [
            new Card(5, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(2, "test", "irrelevant"),
            new Card(1, "test", "irrelevant"),
            new Card(13, "sadlyNotTest", "irrelevant"),
        ];
        $this->assertFalse($testScore->isFlush($testNotFlush));
    }

    public function testIsStraight(): void
    {

        $testScore = new TestScore();

        $testStraight1 = [
            new Card(7, "test", "irrelevant"),
            new Card(8, "test", "irrelevant"),
            new Card(9, "test", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
        ];
        $testStraight2 = [
            new Card(1, "test", "irrelevant"),
            new Card(2, "test", "irrelevant"),
            new Card(3, "test", "irrelevant"),
            new Card(4, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isStraight($testStraight1));
        $this->assertNotFalse($testScore->isStraight($testStraight2));

        $testNotStraight = [
            new Card(1, "test", "irrelevant"),
            new Card(2, "test", "irrelevant"),
            new Card(3, "test", "irrelevant"),
            new Card(4, "test", "irrelevant"),
            new Card(6, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isStraight($testNotStraight));
    }

    public function testIsThreeOfAKind(): void
    {

        $testScore = new TestScore();

        $testThreeOfAKind1 = [
            new Card(7, "test", "irrelevant"),
            new Card(7, "notTest", "irrelevant"),
            new Card(7, "maybeNotTest", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
        ];
        $testThreeOfAKind2 = [
            new Card(3, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
            new Card(3, "notTest", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(3, "maybeNotTest", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isThreeOfAKind($testThreeOfAKind1));
        $this->assertNotFalse($testScore->isThreeOfAKind($testThreeOfAKind2));

        $testNotThreeOfAKind = [
            new Card(3, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
            new Card(7, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(3, "maybeNotTest", "irrelevant"),
        ];
        $this->assertFalse($testScore->isThreeOfAKind($testNotThreeOfAKind));
    }

    public function testIsTwoPair(): void
    {

        $testScore = new TestScore();

        $testTwoPair1 = [
            new Card(7, "test", "irrelevant"),
            new Card(7, "notTest", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(10, "maybeNotTest", "irrelevant"),
        ];
        $testTwoPair2 = [
            new Card(3, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
            new Card(3, "notTest", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(5, "notTest", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isTwoPair($testTwoPair1));
        $this->assertNotFalse($testScore->isTwoPair($testTwoPair2));

        $testNotTwoPair = [
            new Card(3, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
            new Card(7, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(3, "notTest", "irrelevant"),
        ];
        $this->assertFalse($testScore->isTwoPair($testNotTwoPair));
    }

    public function testIsOnePair(): void
    {

        $testScore = new TestScore();

        $testOnePair1 = [
            new Card(7, "test", "irrelevant"),
            new Card(7, "notTest", "irrelevant"),
            new Card(11, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(12, "test", "irrelevant"),
        ];
        $testOnePair2 = [
            new Card(7, "test", "irrelevant"),
            new Card(3, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
            new Card(3, "notTest", "irrelevant"),
            new Card(10, "test", "irrelevant"),
        ];
        $this->assertNotFalse($testScore->isOnePair($testOnePair1));
        $this->assertNotFalse($testScore->isOnePair($testOnePair2));

        $testNotOnePair = [
            new Card(3, "test", "irrelevant"),
            new Card(5, "test", "irrelevant"),
            new Card(7, "test", "irrelevant"),
            new Card(10, "test", "irrelevant"),
            new Card(4, "test", "irrelevant"),
        ];
        $this->assertFalse($testScore->isOnePair($testNotOnePair));
    }
}
