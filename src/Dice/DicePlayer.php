<?php
namespace Lioo19\Dice;

/**
 * Class that will be holding player and computer data.
 */
class DicePlayer
{

    /**
    * @var int $unsavedScore   The current unsaved score for player
    * @var int $savedScore     The score that the player has collected
    */

    protected $playerName;
    protected $unsavedScore;
    protected $savedScore;

    /**
     * Constructor to create player
     *
     * @param int $playerName    Name from player input
     * @param int $unsavedScore  Score for current rolles, not saved
     * @param int $savedScore    Score that has been saved by player
     */
    public function __construct(string $playerName, int $savedScore = null)
    {
        $this->playerName = $playerName;
        $this->unsavedScore = 0;
        if ($savedScore == null) {
            $this->savedScore = 0;
        } else {
            $this->savedScore = $savedScore;
        }
    }


    /**
    * Function to save the score
    * Also resets the current score to 0 (might remove this?)
    *
    * @return void
    */
    public function saveScore()
    {
        $this->savedScore += $this->unsavedScore;
        $this->unsavedScore = 0; //is this neccessary??
    }


    /**
    * Function to reset the unsavedScore variable
    *
    */
    public function resetUnsaved()
    {
        $this->unsavedScore = 0;
    }

    /**
    * Adds the values of the dice to the unsaved score
    *
    * @param int $value Is the value that should be added to the current,
    * unsavedScore
    *
    */
    public function addValues(int $value = 0)
    {
        $this->unsavedScore = $this->unsavedScore + $value;
    }

    /**
    * Fetch the variable savedScore
    *
    * @return int of the savedScore
    *
    */
    public function getSavedScore()
    {
        return $this->savedScore;
    }

    /**
    * Fetch the variable unsavedScore
    *
    * @return int of the unsavedScore
    *
    */
    public function getUnsavedScore()
    {
        return $this->unsavedScore;
    }

    /**
    * method for getting the name of current player
    *
    * @return string name of the player
    */
    public function getName()
    {
        return $this->playerName;
    }
}
