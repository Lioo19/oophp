<?php

namespace Lioo19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Testclass for Dice class
 */
class DiceTest extends TestCase
{
    /**
     * Constructing Dice and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateBasicDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Lioo19\Dice\Dice", $dice);
    }

    /**
     * Test checking that getLastRoll returns int
     *
     */
    public function testGetLastRoll()
    {
        $dice = new Dice();

        $dice->throwDice();

        $result = $dice->getLastRoll();
        $this->assertIsInt($result);
    }

    /**
     * Test Dice with argument 1
     * Meaning dice only has one side, which means throw will result in 1
     */
    public function testCreateDiceWithArg()
    {
        $dice = new Dice(1);

        $dice->throwDice();

        $res = $dice->getLastRoll();
        $expected = 1;

        $this->assertEquals($res, $expected);
    }
}
