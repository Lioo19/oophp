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
    // private $values; //not neccessary, since used in method instead
    private $nrOfSides;


    /**
    * Constructor to initiate the dicehand with a number of dices.
    *
    * @param int $dices Number of dices to create, defaults to five.
    * @param int $nrOfSides Number of sides of the chosen dices
    */
    public function __construct(int $dices = 2, int $nrOfSides = 6)
    {
     // if (!(is_int($nrOfSides) || $nrOfSides > 0)) {
     //     throw new SidesException("Sides on dice need to be at least 1");

        $this->dices  = [];
        $this->nrOfSides = $nrOfSides;

        for ($i = 0; $i < $dices; $i++) {
            array_push($this->dices, new Dice($nrOfSides));
            // $this->values[] = null;
        }
    }
    /**
     * Roll all dice so that the new number is facing upwards
     * Save numbers in array values(is this neccessary?)
     *
     * @return void.
     */
    public function throwDiceHand()
    {
        for ($j=0; $j < count($this->dices); $j++) {
            $throw = $this->dices[$j]->throwDice();
            // array_push($this->values, $throw);
        }
    }

    /**
     * Get all the values from last roll
     * By creating a array of all nums and returning that
     *
     * @return array with them values
     */
    public function allValuesLastRoll()
    {
        $resArr = [];
        for ($i = 0; $i < count($this->dices); $i++) {
            array_push($resArr, $this->dices[$i]->getLastRoll());
        }
        return $resArr;
    }

    /**
     * Get sum of all dices.
     * Should work, but test it out a little extra!
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        $res = array_sum($this->allValuesLastRoll());
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

    /**
    * Check for value, standard case 1
    *
    * @param int @checkForThis The value searched for
    *
    * @return bool True if any dice has the value
    */
    public function checkForValue(int $checkForThis = 1)
    {
        foreach ($this->dices as $dice) {
            if ($dice->getLastRoll() == $checkForThis) {
                return true;
            }
        }
        return false;
    }
}
