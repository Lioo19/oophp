<?php

namespace Lioo19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Testclass for DicePlayer class
 */
class DicePlayerTest extends TestCase
{
    /**
     * Testing the creating of Player with minimal args
     */
    public function testCreateBasicPlayer()
    {
        $dicePlayer = new DicePlayer("Kalle");
        $this->assertInstanceOf("\Lioo19\Dice\DicePlayer", $dicePlayer);
    }

    /**
     * Test creating player with args
     * checking via getPlayerName that it works
     */
    public function testGetPlayerName()
    {
        $dicePlayer = new DicePlayer("Kalle", 3, 6, 0);

        $check = "Kalle";
        $name = $dicePlayer->getPlayerName();

        $this->assertEquals($name, $check);
    }

    /**
     * Testing getSavedScore
     * Saved score added in init
     */
    public function testGetSavedScore()
    {
        $dicePlayer = new DicePlayer("Kalle", 3, 6, 18);

        $res = $dicePlayer->getSavedScore();
        $check = 18;

        $this->assertEquals($res, $check);
    }

    /**
     * Testing throw and getAllValues
     *
     */
    public function testThrowAndDiceHand()
    {
        $dicePlayer = new DicePlayer("Kalle", 3, 6);

        $dicePlayer->throw();
        $first = $dicePlayer->getAllValues();
        $dicePlayer->throw();
        $second= $dicePlayer->getAllValues();


        $this->assertNotEquals($first, $second);
    }

    /**
     * Testing get and reset for DiceHand
     *
     */
    public function testDiceHand()
    {
        $dicePlayer = new DicePlayer("Kalle", 3, 6);

        $dicePlayer->throw();

        $first = $dicePlayer->getDiceHand();

        $second= $dicePlayer->resetDiceHand();


        $this->assertNotEquals($first, $second);
    }

    /**
     * Testing sum
     *
     */
    public function testSum()
    {
        $dicePlayer = new DicePlayer("Kalle", 3, 6);

        $dicePlayer->throw();
        $check = array_sum($dicePlayer->getAllValues());
        $sum = $dicePlayer->sum();

        $this->assertEquals($sum, $check);
    }

    /**
     * Testing addValuesToScore
     * Adding score in init and then via addValuesToScore
     */
    public function testAddValuesToScore()
    {
        $dicePlayer = new DicePlayer("Kalle", 3, 6, 18);

        $dicePlayer->addValuesToScore(18);
        $res = $dicePlayer->getSavedScore();
        $check = 36;

        $this->assertEquals($res, $check);
    }

    /**
     * Testing computerSave
     */
    public function testComputer()
    {
        $dicePlayer = new DicePlayer("Datorn", 3, 6, 85);

        $res = $dicePlayer->computerSave(20);
        $this->assertTrue($res);

        $res2 = $dicePlayer->computerSave(1);
        $this->assertFalse($res2);

        $dicePlayer2 = new DicePlayer("Datorn2", 3, 6, 10);
        $res3 = $dicePlayer2->computerSave(20);
        $this->assertTrue($res3);
    }
}
