<?php
/**
 * Guess my number, a class supporting the game through POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->number = $number;
        $this->tries = $tries;

        $this->createRandomNumber();
    }

    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function createRandomNumber()
    {
        $this->number = rand(1, 100);
    }

    /**
     * Lessen nr of tries with one and return it
     *
     */
    public function triesCountdown()
    {
        $this->tries -= 1;
    }

    /**
     * Show tries left
     *
     * @return int as number of tries made.
     */
    public function triesLeft()
    {
        return $this->tries;
    }

    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function getNumber()
    {
        if ($this->number == -1) {
            $this->createRandomNumber();
        }
        return ($this->number);
    }

    /**
     *
     * @return int as the secret number.
     */
    public function gameOver()
    {
        $gameOver = "<h2>GAME OVER!</h2><br>" .
            "<p>The number has changed. Try again</p>";
        $this->resetGame();
        return $gameOver;
    }

    /**
     * Reset the entire game
     */
    public function resetGame()
    {
        session_destroy();
        session_start();
        $this->tries = 6;
    }

    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($guessedNumber)
    {
        $guessedNumber = (int)$guessedNumber;
        if (!($guessedNumber > 0 && $guessedNumber <= 100)) {
            throw new GuessException("You should guess between 1 and 100.");
        }
        $this->triesCountdown();
        if ($this->tries <= 0) {
            $res = $this->gameOver();
        } else {
            if ($guessedNumber === $this->number) {
                $this->resetGame();
                $res = "<br><h2>CORRECT!</h2>" .
                    "<br><p>If you wanna play again, go for it!" .
                    "<br>The computer has chosen a new number";
            } elseif ($guessedNumber > $this->number) {
                $res = "TOO HIGH";
            } else {
                $res = "TOO LOW";
            }
        }
        return $res;
    }
}
