<?php
/**
 * Routes for dice game
 */


/**
 * Initiate the game and let player choose params
 */
$app->router->get("dice/init", function () use ($app) {
    // Display starting page

    return $app->response->redirect("dice/startdice");
});

/**
 * Play the game! Show game status
 */
$app->router->get("dice/startdice", function () use ($app) {
    $title = "100";

    $app->session->delete("turnScore");
    $app->session->delete("turn");
    $app->session->delete("playing");
    $app->session->delete("sumLastRoll");
    $app->session->delete("getValuesLastRoll");
    $app->session->delete("noDice");
    $app->session->delete("noSides");
    $app->session->delete("playerName");
    $app->session->delete("dice");


    $data = [
        "noDice" => $noDice ?? null,
        "noSides" => $noSides ?? null,
        "playerName" => $playerName ?? "Player 1"
    ];

    $app->page->add("dice/startdice", $data);
    // $app->page->add("dice/debug");


    return $app->page->render([
        "title" => $title
    ]);
});

/**
 * POST route from startdice to playdice, bringing the params with us.
 */
$app->router->post("dice/startdice", function () use ($app) {
    $title = "100";

    $noDice = $_POST["noDice"] ?? 2;
    $noSides = $_POST["noSides"] ?? 6;
    $playerName = $_POST["playerName"] ?? "Player 1";

    $_SESSION["dice"] = new Lioo19\Dice\DiceGame($playerName, $noDice, $noSides);
    $dice = $_SESSION["dice"];

    return $app->response->redirect("dice/playdice");
});


/**
 * playdice GET
 */
$app->router->get("dice/playdice", function () use ($app) {
    $title = "100";

    $dice = $_SESSION["dice"];

    $anyOnes = $dice->anyOnes(); //checkar om det finns några ettor i dice playing getAllValues
    $computerPlaying = $dice->whoIsPlaying(); //check om datorn är den som spelar (true)
    $turn = $dice->getTurn() ?? null; //tar fram turn
    $turnScore = $turn->getTurnScore() ?? null; //tar fram turnScore
    $playing = $dice->getPlaying() ?? null; //tar fram vem som spelar
    $playingHand = $playing->getDiceHand() ?? null; //tar fram spelarens hand
    $getValuesLastRoll = $playingHand->getValuesLastRoll() ?? null; //tar fram senaste värden
    $sumLastRoll = $playingHand->sum() ?? null; //summerar
    $computerChoseSave = null;

    if ($computerPlaying) {
        $computerChoseSave = $dice->goComputerGo() ?? null;
    }

    $scoreBoard = $dice->generateScoreBoard();

    $_SESSION["turnScore"] = $turnScore;
    $_SESSION["getValuesLastRoll"] = $getValuesLastRoll;
    $_SESSION["turn"] = $turn;
    $_SESSION["playing"] = $playing;
    $_SESSION["sumLastRoll"] = $sumLastRoll;

    $restart = $_SESSION["restart"] ?? null;
    $throw = $_SESSION["throw"] ?? null;
    $save = $_SESSION["save"] ?? null;
    $newturn = $_SESSION["newturn"] ?? null;

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
        "save" => $save
    ];

    $computerChoseSave = null;
    $playingHand = null;
    $turn = null;

    $app->page->add("dice/playdice", $data);
    // $app->page->add("dice/debug");


    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * playdice POST
 * ROUTE FOR RESTART WORKS, REDIRECTS TO startdice
 */
$app->router->post("dice/playdice", function () use ($app) {
    $title = "100";
    $dice = $_SESSION["dice"];

    $restart = $_POST["restart"] ?? null;
    $throw = $_POST["throw"] ?? null;
    $save = $_POST["save"] ?? null;
    $newturn = $_POST["newturn"] ?? null;
    $throwcomputer = $_POST["throwcomputer"] ?? null;

    if ($restart) {
        return $app->response->redirect("dice/init");
    } elseif ($throw) {
        return $app->response->redirect("dice/throw");
    } elseif ($save) {
        return $app->response->redirect("dice/save");
    } elseif ($newturn) {
        return $app->response->redirect("dice/newturn");
    } elseif ($throwcomputer) {
        $computerChoseSave = $dice->goComputerGo();
        if ($computerChoseSave) {
            return $app->response->redirect("dice/save");
        } else {
            return $app->response->redirect("dice/throw");
        }
    } else {
        return $app->response->redirect("dice/playdice");
    }
});

/**
 * Throw the dice!
 */

$app->router->get("dice/throw", function () use ($app) {
    $dice = $_SESSION["dice"];

    $dice->makeThrow();

    return $app->response->redirect("dice/playdice");
});

/**
 * Save dice values
 * and reset params for round
 */

$app->router->get("dice/save", function () use ($app) {
    $dice = $_SESSION["dice"];

    $dice->save();

    $_SESSION["turn"] = null;
    $_SESSION["playing"] = null;
    $_SESSION["sumLastRoll"] = null;
    $_SESSION["turnScore"] = null;


    if ($dice->winner()) {
        return $app->response->redirect("dice/winorlose");
    } else {
        return $app->response->redirect("dice/newturn");
    }
});

/**
* continue to new Turn
*/
$app->router->get("dice/newturn", function () use ($app) {
    $dice = $_SESSION["dice"];

    $dice->setNext();

    return $app->response->redirect("dice/playdice");
});

/**
 * Game ends, show win or lose
 */
$app->router->get("dice/winorlose", function () use ($app) {
    $title = "Spelet är över!";
    $dice = $_SESSION["dice"];
    $winningPlayer = $dice->winner() ?? null;
    $scoreBoard = $dice->generateScoreBoard();


    $data = [
        "winningPlayer" => $winningPlayer,
        "scoreBoard" => $scoreBoard
    ];

    $app->page->add("dice/winorlose", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

/**
 * Post route for restarting game when in winorlose
 */
$app->router->post("dice/winorlose", function () use ($app) {
    $dice = $_SESSION["dice"];

    $restart = $_POST["restart"] ?? null;

    if ($restart) {
        return $app->response->redirect("dice/init");
    }
});
