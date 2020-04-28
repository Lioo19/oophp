<?php

namespace Lioo19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Testclass for DiceHistogram class
 */
class DiceHistogramTest extends TestCase
{
    /**
     * Constructing DiceHistogram and verify that the object is created
     */
    public function testCreateBasicDiceHistogram()
    {
        $diceHist = new DiceHistogram("Kalle", 50, 20);
        $this->assertInstanceOf("\Lioo19\Dice\DiceHistogram", $diceHist);
    }

    public function testMax()
    {
        $diceHist = new DiceHistogram("Kalle", 50, 20);

        $diceHist->setSerie([3, 5, 4]);
        $diceHist->printHistogram(6, 1);

        $max = $diceHist->getHistogramMax();
        $this->assertIsInt($max);
    }

    public function testMin()
    {
        $diceHist = new DiceHistogram("Kalle", 50, 20);

        $diceHist->setSerie([3, 5, 4]);
        $diceHist->printHistogram(6, 1);

        $min = $diceHist->getHistogramMin();
        $this->assertIsInt($min);
    }

    public function testgetSerie()
    {
        $diceHist = new DiceHistogram("Kalle", 50, 20);

        $diceHist->setSerie([3, 5, 4]);
        // $diceHist->printHistogram(6, 1);

        $min = $diceHist->getHistogramSerie();
        $this->assertIsArray($min);
    }
}
