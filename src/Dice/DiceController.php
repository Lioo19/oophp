<?php

namespace Lioo19\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A  controller for my Dice game
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the debug method action, it handles:
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game";
    }

    /**
     * This is the index method action
     * redirecting instantly to init
     *
     * @return object
     */
    public function indexAction()
    {
        // Deal with the action and return a response.
        // return "Index!";
        $response = $this->app->response;
        return $response->redirect("dice1/init");
    }

    /**
     * This is the init method action, it initiates the startdice screen
     *
     * @return object
     */
    public function initAction()
    {
        // Display starting page
        $response = $this->app->response;
        return $response->redirect("dice1/startdice");
    }

    /**
     * Get for startplay, renders the page and deletes session-scores
     *
     * @return object
     */
    public function startdiceAction() : object
    {
        $title = "100(1)";
        $session = $this->app->session;
        $page = $this->app->page;


        $session->delete("turnScore");
        $session->delete("turn");
        $session->delete("playing");
        $session->delete("sumLastRoll");
        $session->delete("getValuesLastRoll");
        $session->delete("noDice");
        $session->delete("noSides");
        $session->delete("playerName");
        $session->delete("dice");


        $data = [
            "noDice" => $noDice ?? null,
            "noSides" => $noSides ?? null,
            "playerName" => $playerName ?? "Player 1"
        ];

        $page->add("dice1/startdice", $data);
        // $page->add("dice1/debug");


        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * POST for startdice, records players choice of:
     * name
     * number of dice
     * number of sides on those dice
     *
     * @return object
     */
    public function startdiceActionPost() : object
    {
        $title = "100";
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;

        $noDice = $request->getPost("noDice", 2);
        $noSides = $request->getPost("noSides", 6);
        $playerName = $request->getPost("playerName", "Player 1");

        $session->set("dice", new DiceHistogram($playerName, $noDice, $noSides));
        $dice = $session->get("dice");

        return $response->redirect("dice1/playdice");
    }

    /**
     * Main route for playdice, renders the page
     *
     * @return object
     */
    public function playdiceAction() : object
    {
        $title = "100";
        $session = $this->app->session;
        $page = $this->app->page;

        $dice = $session->get("dice");

        $anyOnes = $dice->anyOnes(); //checkar om det finns några ettor i dice playing getAllValues
        $computerPlaying = $dice->whoIsPlaying(); //check om datorn är den som spelar (true)
        $turn = $dice->getTurn() ?? null; //tar fram turn
        $turnScore = $turn->getTurnScore() ?? null; //tar fram turnScore
        $playing = $dice->getPlaying() ?? null; //tar fram vem som spelar
        $playingHand = $playing->getDiceHand() ?? null; //tar fram spelarens hand
        $getValuesLastRoll = $playingHand->getValuesLastRoll() ?? null; //tar fram senaste värden
        $sumLastRoll = $playingHand->sum() ?? null; //summerar
        // $histogram = $dice->generateHistogram() ?? null; //tar fram histogrammet
        $computerChoseSave = null;

        if ($computerPlaying) {
            $computerChoseSave = $dice->goComputerGo() ?? null;
        }

        $scoreBoard = $dice->generateScoreBoard();

        $session->set("turnScore", $turnScore);
        $session->set("getValuesLastRoll", $getValuesLastRoll);
        $session->set("turn", $turn);
        $session->set("playing", $playing);
        $session->set("sumLastRoll", $sumLastRoll);

        $restart = $session->get("restart", null);
        $throw = $session->get("throw", null);
        $save = $session->get("save", null);
        $newturn = $session->get("newturn", null);

        $nrOfSides = $playingHand->getNrOfSides();
        $dice->setSerie($getValuesLastRoll);
        $histogram = $dice->printHistogram($nrOfSides, 1);

        $data = [
            "playing" => $playing,
            "turn" => $turn,
            "playingHand" => $playingHand,
            "turnScore" => $turnScore,
            "sumLastRoll" => $sumLastRoll,
            "getValuesLastRoll" => $getValuesLastRoll,
            "computerPlaying" => $computerPlaying,
            "anyOnes" => $anyOnes,
            "computerChoseSave" => $computerChoseSave,
            "restart" => $restart,
            "throw" => $throw,
            "scoreBoard" => $scoreBoard,
            "save" => $save,
            "histogram" => $histogram
        ];

        $computerChoseSave = null;
        $playingHand = null;
        $turn = null;

        $page->add("dice1/playdice", $data);
        // $page->add("dice1/debug");

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * POST for playdice, makes sure the game works and sends stuff.
     *
     * @return object
     */
    public function playdiceActionPost() : object
    {
        $title = "100";
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;

        $dice = $session->get("dice");

        //Null är default, ska klara sig utan.
        $restart = $request->getPost("restart");
        $throw = $request->getPost("throw");
        $save = $request->getPost("save");
        $newturn = $request->getPost("newturn");
        $throwcomputer = $request->getPost("throwcomputer");

        if ($restart) {
            return $response->redirect("dice1/init");
        } elseif ($throw) {
            return $response->redirect("dice1/throw");
        } elseif ($save) {
            return $response->redirect("dice1/save");
        } elseif ($newturn) {
            return $response->redirect("dice1/newturn");
        } elseif ($throwcomputer) {
            $computerChoseSave = $dice->goComputerGo();
            if ($computerChoseSave) {
                return $response->redirect("dice1/save");
            } else {
                return $response->redirect("dice1/throw");
            }
        } else {
            return $response->redirect("dice1/playdice");
        }
    }

    /**
     * When player hits button "throw", this is where it ends up
     * redirects to playdice
     *
     * @return object
     */
    public function throwAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $dice = $session->get("dice");

        $dice->makeThrow();
        // $session->set("histogram", $dice->getHistogram());

        return $response->redirect("dice1/playdice");
    }

    /**
     * Route for when player presses save
     *
     * @return object
     */
    public function saveAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $dice = $session->get("dice");

        $dice->save();

        $session->set("turn", null);
        $session->set("playing", null);
        $session->set("sumLastRoll", null);
        $session->set("turnScore", null);

        if ($dice->winner()) {
            return $response->redirect("dice1/winorlose");
        } else {
            return $response->redirect("dice1/newturn");
        }
    }

    /**
     * generates a new turn
     *
     * @return object
     */
    public function newturnAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;
        $dice = $session->get("dice");

        $dice->setNext();

        return $response->redirect("dice1/playdice");
    }

    /**
     * get for winorlose, player ends up here when game over
     *
     * @return object
     */
    public function winorloseAction() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $title = "Spelet är över!";
        $dice = $session->get("dice");
        $winningPlayer = $dice->winner() ?? null;
        $scoreBoard = $dice->generateScoreBoard();

        $data = [
            "winningPlayer" => $winningPlayer,
            "scoreBoard" => $scoreBoard
        ];

        $page->add("dice1/winorlose", $data);

        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * POST route for winorlose, if player wants to restart game
     *
     * @return object
     */
    public function winorloseActionPost()
    {
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;


        $dice = $session->get("dice");

        $restart = $request->getPost("restart");

        if ($restart) {
            return $response->redirect("dice1/init");
        }
    }
}
