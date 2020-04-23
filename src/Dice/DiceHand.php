<?php
namespace Lioo19\Dice;

/**
 * Class for rolling a DiceHand
 *
 */
class DiceHand
{

    /**
    * @var Dice $dices   Array consisting of dices.
    * @var int  $values  Array consisting of last roll of the dices.
    */
    private $dices;
    private $nrOfSides;
    private $values;


    /**
    * Constructor to initiate the dicehand with a number of dices.
    *
    * @param int $dices Number of dices to create, defaults to five.
    * @param int $nrOfSides Number of sides of the chosen dices
    */
    public function __construct(int $dices = 2, int $nrOfSides = 6)
    {
        $this->dices  = [];
        $this->values  = [];
        $this->nrOfSides = $nrOfSides;

        for ($i = 0; $i < $dices; $i++) {
            array_push($this->dices, new Dice($nrOfSides));
        }
    }
    /**
     * Roll all dice so that the new number is facing upwards
     * Save numbers in array values
     *
     * @return void.
     */
    public function throwDiceHand()
    {
        $this->values = [];
        $noDice = count($this->dices);
        for ($j=0; $j < $noDice; $j++) {
            $this->dices[$j]->throwDice();
            $this->values[] = $this->dices[$j]->getLastRoll();
        }
    }

    /**
     * Returning all values from last roll
     *
     * @return array with them values
     */
    public function getValuesLastRoll()
    {
        return $this->values;
    }

    /**
     * Get sum of all dices.
     * Should work, but test it out a little extra!
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        $res = array_sum($this->getValuesLastRoll());
        return $res;
    }

    /**
     * Get the average of all dices thrown
     *
     * @return float representing the average of all dice
     * rounded to two decimals
     */
    public function average()
    {
        return ( $this->sum() / count($this->dices));
    }
}
