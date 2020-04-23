<?php

namespace Lioo19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Testclass for DiceHand class
 */
class DiceHandTest extends TestCase
{
    /**
    * Test method for average of DiceHandResult
    */
    public function testAverage()
    {
        $diceHand = new DiceHand(4, 6);

        $diceHand->throwDiceHand();

        $avg = $diceHand->average();
        $sum = $diceHand->sum() / 4;

        $this->assertEquals($avg, $sum);
    }

     /**
      * Test sum to see that it calculates correct sum
      */
    public function testsum()
    {
        $diceHand = new DiceHand(4);

        $diceHand->throwDiceHand();

        $val = $diceHand->getValuesLastRoll();
        $manual = array_sum($val);

        $res = $diceHand->sum();

        $this->assertEquals($res, $manual);
    }


    /**
    * Test that throw generates different results each time
    */
    public function testThrow()
    {
        $diceHand = new DiceHand(3);
        $diceHand->throwDiceHand();
        $firstRes = $diceHand->getValuesLastRoll();

        $diceHand->throwDiceHand();
        $secondRes = $diceHand->getValuesLastRoll();

        $this->assertNotEquals($secondRes, $firstRes);
    }
}
