<?php
/**
 * Routes for dice game
 */


/**
 * Initiate the game and let player choose params
 */
$app->router->get("dice/init", function () use ($app) {
    // Initiate the session for game start

    return $app->response->redirect("dice/startdice");
});

/**
 * Play the game! Show game status
 */
$app->router->get("dice/startdice", function () use ($app) {
    $title = "100";

    $app->session->delete("res");
    $app->session->delete("number");
    $app->session->delete("tries");
    $app->session->delete("guess");
    $app->session->delete("guessedNumber");
    $app->session->delete("makeGuess");
    $app->session->delete("cheat");
    $app->session->delete("startOver");
    $app->session->delete("noSides");
    $app->session->delete("noDice");
    $app->session->delete("dice");
    $app->session->delete("throw");
    $app->session->delete("lastRoll");
    $app->session->delete("unsavedScore");
    $app->session->delete("playerName");
    $app->session->delete("gocomputergo");

    $data = [
        "noDice" => $noDice ?? null,
        "noSides" => $noSides ?? null,
        "playerName" => $playerName ?? "Player 1"
    ];

    $app->page->add("dice/startdice", $data);
    $app->page->add("dice/debug");


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

    $_SESSION["noDice"] = $noDice;
    $_SESSION["noSides"] = $noSides;
    $_SESSION["playerName"] = $playerName;

    return $app->response->redirect("dice/playdice");
});


/**
 * playdice GET
 */
$app->router->get("dice/playdice", function () use ($app) {
    $title = "100";

    $noDice = $_SESSION["noDice"] ?? 2;
    $noSides = $_SESSION["noSides"] ?? 6;
    $playerName = $_SESSION["playerName"] ?? "Player 1";

    $_SESSION["dice"] = new Lioo19\Dice\DiceGame($playerName, $noDice, $noSides);
    $dice = $_SESSION["dice"];

    // var_dump($app->session);
    var_dump($dice->human->getUnsavedScore());

    $scoreBoard = $dice->generateScoreBoard();

    $restart = $_SESSION["restart"] ?? null;
    $throw = $_SESSION["throw"] ?? null;
    $save = $_SESSION["save"] ?? null;
    $lastRoll = $_SESSION["lastRoll"] ?? null;
    $unsavedScore = $_SESSION["unsavedScore"] ?? null;
    $gocomputergo = $_SESSION["gocomputergo"] ?? null;


    $data = [
        "restart" => $restart,
        "throw" => $throw,
        "scoreBoard" => $scoreBoard,
        "lastRoll" => $lastRoll,
        "unsavedScore" => $unsavedScore,
        "save" => $save,
        "gocomputergo" => $gocomputergo
    ];

    $app->page->add("dice/playdice", $data);
    $app->page->add("dice/debug");


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
    $dice = $_SESSION["dice"] ?? null;
    $gocomputergo = $_SESSION["gocomputergo"] ?? null;

    $restart = $_POST["restart"] ?? null;
    $throw = $_POST["throw"] ?? null;
    $save = $_POST["save"] ?? null;
    $throwcomputer = $_POST["throwcomputer"] ?? null;

    if ($restart) {
        return $app->response->redirect("dice/init");
    } elseif ($throw) {
        return $app->response->redirect("dice/throw");
    } elseif ($save) {
        return $app->response->redirect("dice/save");
    } elseif ($throwcomputer) {
        return $app->response->redirect("dice/gocomputergo");
    }

    $_SESSION["throw"] = $throw;
    $_SESSION["restart"] = $restart;
    $_SESSION["save"] = $save;
    $_SESSION["gocomputergo"] = $gocomputergo;
    $_SESSION["throwcomputer"] = $throwcomputer;

    return $app->response->redirect("dice/playdice");
});

/**
 * Throw the dice!
 */

$app->router->get("dice/throw", function () use ($app) {
    $dice = $_SESSION["dice"];

    //gocomputergo is either false, then human cont., or true in which is comps turn
    $gocomputergo = $dice->makeThrow();
    $lastRoll = $dice->diceHand->allValuesLastRoll();
    $unsavedScore = $dice->human->getUnsavedScore();

    $_SESSION["gocomputergo"] = $gocomputergo;
    $_SESSION["lastRoll"] = $lastRoll;
    $_SESSION["unsavedScore"] = $unsavedScore;

    return $app->response->redirect("dice/playdice");
});

/**
 * Save dice values
 */

$app->router->get("dice/save", function () use ($app) {
    $dice = $_SESSION["dice"];

    $dice->human->saveScore();
    $gocomputergo = true;

    if ($dice->winner()) {
        return $app->response->redirect("dice/winorlose");
    } else {
        $_SESSION["gocomputergo"] = $gocomputergo;
        return $app->response->redirect("dice/playdice");
    }
});

/**
 * Play for computer
 */

$app->router->get("dice/gocomputergo", function () use ($app) {
    $dice = $_SESSION["dice"];

    $dice->goComputerGo();

    $computerSaved = $dice->computer->getSavedScore();
    $_SESSION["computerSaved"] = $computerSaved;

    if ($dice->winner()) {
        return $app->response->redirect("dice/winorlose");
    } else {
        return $app->response->redirect("dice/playdice");
    }
});

/**
 * Game ends, show win or lose
 */
$app->router->get("dice/winorlose", function () use ($app) {
    $title = "Spelet är över!";
    $dice = $_SESSION["dice"];
    // $players = $_SESSION["players"];
    // $currentPlayer = $dicegame->getCurrentPlayer() ?? null;

    $data = [
        "dice" => $dice
    ];

    $app->page->add("dice/winorlose", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
