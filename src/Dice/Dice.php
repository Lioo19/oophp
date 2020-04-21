<?php
namespace Lioo19\Dice;

/**
 * Class for rolling a dice
 * functional and working!
 */
class Dice
{
    /**
    * @var sides $sides   Sides of dice
    * @var int  $lastRoll  int holding last roll in no.
    */
    private $sides;
    private $lastRoll;

    /**
     * Constructor to create a new dice.
     *
     * @param 6|int    $nrOfSides  The number of sides on a dice
     */
    public function __construct(int $nrOfSides = 6)
    {
        // if (!(is_int($nrOfSides) || $nrOfSides > 0)) {
        //     throw new SidesException("Sides on dice need to be at least 1");
        // }

        $this->sides = $nrOfSides;
        $this->lastRoll = null;
    }

    public function throwDice()
    {
        $this->thrown = rand(1, $this->sides);
        $this->lastRoll = $this->thrown;
        return $this->thrown;
    }

    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
