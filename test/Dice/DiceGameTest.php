<?php

namespace Lioo19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Testclass for DiceGame class
 */
class DiceGameTest extends TestCase
{
    /**
     * Constructing DiceGame and verify that the object is created
     * three times for initDice test, probability is that starting will vary
     */
    public function testCreateBasicDiceGame()
    {
        $diceGame = new DiceGame("Kalle");
        $this->assertInstanceOf("\Lioo19\Dice\DiceGame", $diceGame);

        $diceGame = new DiceGame("Robert", 3, 10);
        $this->assertInstanceOf("\Lioo19\Dice\DiceGame", $diceGame);

        $diceGame = new DiceGame("Pelle", 50, 20);
        $this->assertInstanceOf("\Lioo19\Dice\DiceGame", $diceGame);
    }

    /**
     * Test getTurn and Throw
     *
     */
    public function testMakeThrowAndGetTurnScore()
    {
        $diceGame = new DiceGame("Kalle");

        $diceGame->makeThrow();
        $turnScore = $diceGame->getTurn()->getTurnScore();

        $diceGame->makeThrow();
        $turnScore2 = $diceGame->getTurn()->getTurnScore();

        $this->assertNotEquals($turnScore, $turnScore2);
    }

    /**
    * Test for setNext, which also tests
     * Test for switch and get Playing
     *
     */
    public function testSwitchPlayingGetPlaying()
    {
        $diceGame = new DiceGame("Kalle");

        $first = $diceGame->getPlaying();

        $diceGame->setNext();
        $second = $diceGame->getPlaying();

        $this->assertNotEquals($first, $second);

        $third = $diceGame->switchPlaying();
        $this->assertNotEquals($second, $third);
    }

    /**
    * Test that scoreBoard generates a string
    *
    */
    public function testScoreBoard()
    {
        $diceGame = new DiceGame("Kalle");

        $res = $diceGame->generateScoreBoard();
        $this->assertIsString($res);
    }

    /**
    * Test that goComputerGo generates bool
    * test whoIsPlaying generates bool
    *
    */
    public function testGoComputerGoAndWhoIsPlaying()
    {
        $diceGame = new DiceGame("Kalle");

        $res1 = $diceGame->goComputerGo();
        $this->assertIsBool($res1);

        $res2 = $diceGame->whoIsPlaying();
        $this->assertIsBool($res2);
    }

    /**
    * Test for winner and anyOnes
    * First case only one dice
    * Use 200 dice to ensure winner and ones
    *
    */
    public function testWinnerAndAnyOnes()
    {
        $diceGame = new DiceGame("Kalle", 1, 6);
        $diceGame->makeThrow();
        $diceGame->save();

        $notWinner = $diceGame->winner();
        $this->assertNull($notWinner);

        $diceGame = new DiceGame("Kalle", 200, 6);
        $diceGame->makeThrow();
        $diceGame->save();

        $winner = $diceGame->winner();

        $this->assertNotNull($winner);

        $anyOnes = $diceGame->anyOnes();
        $this->assertTrue($anyOnes);
    }
}
