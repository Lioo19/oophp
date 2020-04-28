<?php
namespace Lioo19\Dice;

/**
 * Class for entire diceGame
 *
 * EN MÄNNISKA, EN DATOR
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceGame
{
    /**
    * @var DicePlayer $human - The user playing
    * @var DiceComputer $computer - The computer playing
    * @var DiceTurn $turn - The turn being played
    * @var DicePlayer $playing the player playing right now
    *
    */
    public $human;
    public $computer;
    private $turn;
    private $playing;

    /**
     * Constructor to create the DiceGame class
     *
     * @param string   $playerName Input giver for player name
     * @param 2|int    $noDice  The number of dices, standard 2
     * @param 6|int    $noSides  The number of sides on a dice, standard 6
     *
     */
    public function __construct(string $playerName = "Player 1", int $noDice = 2, int $noSides = 6)
    {
        //Constructor for the game itself

        $this->human = new DicePlayer($playerName, $noDice, $noSides, 0);
        $this->computer = new DicePlayer("Datorn", $noDice, $noSides, 0);
        $initdice = new Dice();


        //Starting throw to determine who begins
        // Even numbers, the human starts.
        $firstThrow = $initdice->throwDice();
        // $firstThrow = 4; //Only for simple testing
        if ($firstThrow % 2 == 0) {
            $this->turn = new DiceTurn($this->human);
            $this->playing = $this->human;
        } else {
            $this->turn = new DiceTurn($this->computer);
            $this->playing = $this->computer;
        }
    }

    /**
    * Change player from current to next player
    * by checking who is currently playing
    * Public to enable testing
    *
    * @return void
    */
    public function switchPlaying()
    {
        if ($this->playing->getPlayerName() == "Datorn") {
            $this->playing = $this->human;
        } else {
            $this->playing = $this->computer;
        }
    }

    /**
    * Creating a dice roll
    * and setting the sum of the turnScore
    *
    * @return void
    */
    public function makeThrow()
    {
        $this->playing->throw();
        $sum = $this->playing->sum();
        $this->turn->setTurnScore($sum);
    }

    /**
    * Saving the values from a turn to player score
    * activated when a player presses save
    *
    * @return void
    */
    public function save()
    {
        $sum = $this->turn->getTurnScore();
        $this->playing->addValuesToScore($sum);
    }

    /**
     * create new turn by creating new DiceTurn
     *
     * @return void
     */

    public function newTurn()
    {
        if ($this->playing->getPlayerName() == "Datorn") {
            $this->turn = new DiceTurn($this->human);
        } else {
            $this->turn = new DiceTurn($this->computer);
        }
    }

    /**
    * Create the next turn
    * Reset diceHand and swich playing
    * Done before switch for if-statement to work
    *
    * @return void
    */
    public function setNext()
    {
        $this->playing->resetDiceHand();
        $this->newTurn();
        $this->switchPlaying();
    }

    /**
     * Method for checking if computer should save, relying on
     * method compuerSave in Class DicePlayer
     *
     * @return bool true if computer saves, false otherwise
     */

    public function goComputerGo()
    {
        $turnScore = $this->turn->getTurnScore();
        $checkScore = $this->checkScore();
        $choice = $this->computer->computerSave($turnScore, $checkScore);

        return $choice;
    }

    /**
     * Who is playing?
     * Computer = true
     * Human = false
     * @return bool true if computer, false otherwise
     */

    public function whoIsPlaying()
    {
        if ($this->playing->getPlayerName() == "Datorn") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check the score inbetween the two players.
     * the else is returning the score if they're the same
     * @return int $leaderScore
     */

    public function checkScore()
    {
        $playerScore = $this->human->getSavedScore();
        $computerScore = $this->computer->getSavedScore();

        if ($playerScore > $computerScore) {
            return $playerScore;
        } elseif ($playerScore < $computerScore) {
            return $computerScore;
        } else {
            return $playerScore;
        }
    }

    /**
     * Returns true if any of the dices has a value of 1
     *
     * @return bool true if 1 is found
     */

    public function anyOnes()
    {
        $currentThrow = $this->playing->getAllValues();
        $res = false;
        foreach ($currentThrow as $cT) {
            if ($cT == 1) {
                $res = true;
            }
        }
        return $res;
    }

    /**
     * Check for winner
     *
     * @return string as winner or null if there is no winner yet.
     */
    public function winner()
    {
        if ($this->human->getSavedScore() >= 100) {
            return $this->human->getPlayerName();
        } elseif ($this->computer->getSavedScore() >= 100) {
            return $this->computer->getPlayerName();
        } else {
            return null;
        }
    }

    /**
     * Generates the current scoreboard
     *
     * @return string as the scoreboard.
     */
    public function generateScoreBoard()
    {
        $table = '<table><tr><th>Spelare</th><th>Poäng</th></tr>';

        $hName = $this->human->getPlayerName();
        $hScore = $this->human->getSavedScore();
        $table .= '<tr><td>' . $hName . '</td><td>' . $hScore . '</td></tr>';

        $cName = $this->computer->getPlayerName();
        $cScore = $this->computer->getSavedScore();
        $table .= '<tr><td>' . $cName . '</td><td>' . $cScore . '</td></tr>';

        $table .= '</table>';
        return $table;
    }

    /**
     * get playing player
     *
     * @return DicePlayer $playing
     */

    public function getplaying()
    {
        return $this->playing;
    }

    /**
     * get players current turn
     *
     * @return DiceTurn $turn
     */

    public function getTurn()
    {
        return $this->turn;
    }
}
