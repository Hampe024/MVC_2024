<?php

namespace App\Card;

use App\Card\Board;
use App\Card\Card;

use Exception;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Board.
 */
class BoardTest extends TestCase
{
    public function testGetBoard(): void
    {
        $board = new Board();

        $this->assertInstanceOf("\App\Card\Board", $board);
        $this->assertSame($board->getBoard(), [
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
        ]);
    }

    public function testSetCard(): void
    {
        $board = new Board();
        $card = new Card(2, "s", "🂢");

        $board->setCard($card, 0, 0);
        $board->setCard($card, 2, 0);
        $board->setCard($card, 4, 1);
        $board->setCard($card, 3, 4);

        $this->assertSame($board->getBoard(), [
            [$card, null, $card, null, null],
            [null, null, null, null, $card],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, $card, null],
        ]);
    }

    public function testSetCardException(): void
    {
        $this->expectException(\Exception::class);

        $board = new Board();
        $card1 = new Card(1, "s", "🂢");
        $card2 = new Card(2, "s", "🂢");

        $board->setCard($card1, 0, 0);
        $board->setCard($card2, 0, 0);

        $this->assertSame($board->getBoard(), [
            [$card1, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, null, null],
        ]);
    }

    public function testIsFull(): void
    {
        $board = new Board();
        $card = new Card(2, "s", "🂢");

        $this->assertFalse($board->isFull());

        $board->setCard($card, 0, 0);
        $board->setCard($card, 2, 0);
        $board->setCard($card, 4, 1);
        $board->setCard($card, 3, 4);
        $this->assertSame($board->getBoard(), [
            [$card, null, $card, null, null],
            [null, null, null, null, $card],
            [null, null, null, null, null],
            [null, null, null, null, null],
            [null, null, null, $card, null],
        ]);

        $this->assertFalse($board->isFull());

        $board->setCard($card, 0, 1);
        $board->setCard($card, 0, 2);
        $board->setCard($card, 0, 3);
        $board->setCard($card, 0, 4);

        $board->setCard($card, 1, 0);
        $board->setCard($card, 1, 1);
        $board->setCard($card, 1, 2);
        $board->setCard($card, 1, 3);
        $board->setCard($card, 1, 4);

        $board->setCard($card, 2, 1);
        $board->setCard($card, 2, 2);
        $board->setCard($card, 2, 3);
        $board->setCard($card, 2, 4);

        $board->setCard($card, 3, 0);
        $board->setCard($card, 3, 1);
        $board->setCard($card, 3, 2);
        $board->setCard($card, 3, 3);

        $board->setCard($card, 4, 0);
        $board->setCard($card, 4, 2);
        $board->setCard($card, 4, 3);

        $this->assertFalse($board->isFull());

        $board->setCard($card, 4, 4);

        $this->assertSame($board->getBoard(), [
            [$card, $card, $card, $card, $card],
            [$card, $card, $card, $card, $card],
            [$card, $card, $card, $card, $card],
            [$card, $card, $card, $card, $card],
            [$card, $card, $card, $card, $card],
        ]);

        $this->assertTrue($board->isFull());
    }

    public function testGetPoints(): void
    {
        $board = new Board();
        $card1 = new Card(1, "s", "🂢");
        $card2 = new Card(2, "s", "🂢");
        $card3 = new Card(3, "s", "🂢");
        $card4 = new Card(4, "s", "🂢");
        $card5 = new Card(5, "s", "🂢");
        $card6 = new Card(6, "s", "🂢");
        $card7 = new Card(7, "s", "🂢");
        $card8 = new Card(8, "s", "🂢");
        $card9 = new Card(9, "s", "🂢");
        $card10 = new Card(10, "s", "🂢");

        $board->setCard($card1, 0, 0);
        $board->setCard($card2, 1, 0);
        $board->setCard($card3, 2, 0);
        $board->setCard($card4, 3, 0);
        $board->setCard($card5, 4, 0);
        $board->setCard($card6, 1, 1);
        $board->setCard($card7, 1, 2);
        $board->setCard($card8, 1, 3);
        $board->setCard($card9, 1, 4);
        $board->setCard($card10, 4, 4);

        $this->assertSame($board->getBoard(), [
            [$card1, $card2, $card3, $card4, $card5],
            [null, $card6, null, null, null],
            [null, $card7, null, null, null],
            [null, $card8, null, null, null],
            [null, $card9, null, null, $card10],
        ]);
        // setup done

        $this->assertEquals($board->getPoints(1, 5), 5);
        // should use cards [$card2, $card6, $card7, $card8, $card9] and return as a flush(5 points)
        $this->assertEquals($board->getPoints(2, 5), 0);
        // should use cards [$card3, null, null, null, null] and return as nothing(0 points)
        $this->assertEquals($board->getPoints(4, 5), 0);
        // should use cards [$card4, null, null, null, $card10] and return as nothing(0 points)
        $this->assertEquals($board->getPoints(5, 0), 30);
        // should use cards [$card1, $card2, $card3, $card4, $card5] and return as a straight flush(30 points)


    }
}