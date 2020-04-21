<?php
namespace Lioo19\Dice;

/**
 * Class for entire diceGame
 *
 * EN MÄNNISKA, EN DATOR
 *
 * Två params, en för antal tärningar och en för antal sidor per tärning
 */
class DiceGame
{

    /**
    * @var int $noSides - amount of sides for each die
    * @var int $noDice - amount of dice for each throw
    * @var DicePlayer $human - The user playing
    * @var DiceComputer $computer - The computer playing
    */
    public $human;
    public $computer;
    protected $noSides;
    protected $noDice;

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

        $this->noDice = $noDice;
        $this->noSides = $noSides;
        $this->diceHand = new DiceHand($this->noDice, $this->noSides);
        $this->human = new DicePlayer($playerName);
        $this->computer = new DicePlayer("Computer");
    }


    /**
    * Creating a dice roll for $human or $computer
    *
    * @param bool $saveScore checks to see if score should be saved
    *
    * @return bool true if checkForValue is found, else false
    */
    public function makeThrow()
    {
        $this->diceHand->throwDiceHand();
        if ($this->diceHand->checkForValue(1)) {
            $this->human->resetUnsaved();
            return true;
        } else {
            $sum = $this->diceHand->sum();
            $this->human->addValues($sum);
            return false;
        }
    }

    /**
     * Check for winner
     *
     * @return string as winner or null if there is no winner yet.
     */
    public function winner()
    {
        if ($this->human->getSavedScore() > 100) {
            return $this->human->getName();
        } elseif ($this->computer->getSavedScore() > 100) {
            return $this->computer->getName();
        } else {
            return null;
        }
    }

    /**
     * Runs the computers turn
     *
     * @return void
     */
    public function goComputerGo()
    {
        $finished = false;
        do {
            $this->diceHand->throwDiceHand();
            if ($this->diceHand->checkForValue(1)) {
                $this->computer->resetUnsaved();
                $finished = true;
            } else {
                $this->computer->addValues($this->diceHand->sum());
            }

            if ($this->shouldComputerSave()) {
                $this->computer->saveScore();
                $finished = true;
            }
        } while ($finished == false);

        if ($this->computer->getSavedScore() < 100) {
            $this->makeThrow(false);
        }
    }

    /**
     * Check if computer should save
     *
     * @return bool True if save should be done
     */
    private function shouldComputerSave()
    {

        if (8 < $this->diceHand->sum() || 20 < $this->computer->getUnsavedScore()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Generates the current scoreboard
     *
     * @return string as the scoringboard.
     */
    public function generateScoreBoard()
    {
        $table = '<table><tr><th>Spelare</th><th>Poäng</th></tr>';

        $hName = $this->human->getName();
        $hScore = $this->human->getSavedScore();
        $table .= '<tr><td>' . $hName . '</td><td>' . $hScore . '</td></tr>';

        $cName = $this->computer->getName();
        $cScore = $this->computer->getSavedScore();
        $table .= '<tr><td>' . $cName . '</td><td>' . $cScore . '</td></tr>';

        $table .= '</table>';
        return $table;
    }

}
