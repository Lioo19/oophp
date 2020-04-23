<?php

namespace Lioo19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Testclass for Dice class
 */
class DiceTurnTest extends TestCase
{
    /**
     * Constructing DicePlayer and then DiceTurn.
     *
     */
    public function testCreateBasicTurn()
    {
        $dicePlayer = new DicePlayer("Kalle");
        $diceTurn = new DiceTurn($dicePlayer);
        $this->assertInstanceOf("\Lioo19\Dice\DiceTurn", $diceTurn);
    }

    /**
     * Test checking that getTurnScore works
     *
     */
    public function testTurnScore()
    {
        $dicePlayer = new DicePlayer("Kalle");
        $diceTurn = new DiceTurn($dicePlayer, 28);

        $res = $diceTurn->getTurnScore();
        $check = 28;
        $this->assertEquals($res, $check);
    }

    /**
     * Test setTurnScore, with the help of getTurnScore
     *
     */
    public function testsetTurnScore()
    {
        $dicePlayer = new DicePlayer("Kalle");

        $diceTurn = new DiceTurn($dicePlayer, 28);

        $diceTurn->setTurnScore(2);

        $res = $diceTurn->getTurnScore();
        $check = 30;
        $this->assertEquals($res, $check);
    }
}
