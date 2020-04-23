<?php
namespace Lioo19\Dice;

/**
 * Class that will be holding player and computer data.
 */
class DicePlayer
{

    /**
    * @var int $savedScore     The current, saved score for player
    * @var string $playerName     Name of the player playing
    * @var int $noDice         The number of dice
    * @var DiceHand $diceHand       The dicehand, relying on the class diceHand
    */

    private $playerName;
    private $savedScore;
    private $noDice;
    private $diceHand;

    /**
     * Constructor to create player
     *
     * @param string $playerName    Name from player input
     * @param int $savedScore       Saved Score
     * @param int $noDice           The number of dice
     * @param int $noSides          The number of sides on a dice, default 6
     * @param DiceHand $diceHand    diceHand
     */
    public function __construct(string $playerName, int $noDice = 2, int $noSides = 6, int $savedScore = null)
    {
        $this->savedScore = $savedScore;
        $this->noDice = $noDice;
        $this->noSides = $noSides;
        $this->playerName = $playerName;
        $this->diceHand = new DiceHand($this->noDice, $this->noSides);
    }

    /**
     * Throw all dices in playerHand
     *
     * @return void.
     */

    public function throw()
    {
        $this->diceHand->throwDiceHand();
    }

    /**
     * Return player score
     *
     * @return int $score      Player score
     */

    public function getSavedScore()
    {
        return $this->savedScore;
    }

    /**
    * Retrive diceHand
    *
    * @return DiceHand class
    */
    public function getDiceHand()
    {
        return $this->diceHand;
    }

    /**
    * Reset for diceHand
    *
    * @return object new DiceHand
    */
    public function resetDiceHand()
    {
        return $this->diceHand = new DiceHand($this->noDice, $this->noSides);
    }

    /**
     * Return all values in players Hand
     *
     * @return array   Array cont. dice values
     */

    public function getAllValues()
    {
        return $this->diceHand->getValuesLastRoll();
    }

    /**
     * Get the sum of players hand
     *
     * @return int
     */

    public function sum()
    {
        return $this->diceHand->sum();
    }


    /**
     * Get player name
     *
     * @return string
     */

    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
    * Add values to the saved Player score
    * @param int $unsavedValues   All values from dice of this round
    *
    * @return void
    */

    public function addValuesToScore(int $unsavedValues = 0)
    {
        $this->savedScore = $this->savedScore + $unsavedValues;
    }

    /**
    * ONLY TO BE USED FOR COMPUTER CHOICE
    * Logic to make decision for computer
    * Right now static but could be changed depending on dice?
    *
    * @param int $unsavedValue
    * @return bool true if computer should save the throw, false if not.
    */
    public function computerSave(int $unsavedValue = 0)
    {
        $save = false;

        if ($this->savedScore + $unsavedValue >= 100) {
            $save = true;
        } else if ($unsavedValue >= 20) {
            $save = true;
        } else {
            $save = false;
        }

        return $save;
    }
}
