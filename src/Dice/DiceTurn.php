<?php

 namespace Lioo19\Dice;

 /**
 * One players turn, which stops when they press save
 */
class DiceTurn
{
    /**
     * @var int $turnScore   current score for the turn
     * @var DicePlayer $player   Player playing
     */
    private $turnScore;
    private $player;

    /**
     * Constructing one turn
     *
     * @param DicePlayer $player   Player playing
     * @param int $turnScore   current score for the turn
     */

    public function __construct($player, int $turnScore = 0)
    {
        $this->player = $player;
        $this->turnScore = $turnScore;
    }

    /**
     * get total score for the turn
     *
     * @return int $TurnScore  Sum of all dice rolled this turn,
     */

    public function getTurnScore()
    {
        return $this->turnScore;
    }

    /**
     * Set turnScore, and update as turn progresses
     *
     * @param int $lastRoll   Sum from last roll
     */

    public function setTurnScore(int $lastRoll = 0)
    {
        $this->turnScore += $lastRoll;
    }
}
