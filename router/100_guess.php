<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Initiate the game and make a redirect
 */
$app->router->get("guess/init", function () use ($app) {
    // Initiate the session for game start
    $_SESSION["res"]  = null;
    $_SESSION["makeGuess"] = null;
    $_SESSION["guessedNumber"] = null;
    $_SESSION["cheat"] = null;
    $_SESSION["guess"] = new Lioo19\Guess\Guess();
    return $app->response->redirect("guess/play");
});

/**
 * Play the game! Show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "GUESS";
    $guess = $_SESSION["guess"];
    $number = $guess->getNumber();
    $tries = $guess->triesLeft();
    $guessedNumber = $_SESSION["guessedNumber"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $makeGuess = $_SESSION["makeGuess"] ?? null;
    $cheat = $_SESSION["cheat"] ?? null;

    $data = [
        "guess" => $guess,
        "number" => $number,
        "tries" => $tries,
        "makeGuess" => $makeGuess ?? null,
        "guessedNumber" => $guessedNumber ?? null,
        "startOver" => $startOver ?? null,
        "cheat" => $cheat ?? null,
        "res" => $res
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game! Make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Guess";

    $guessedNumber = $_POST["guessedNumber"] ?? null;
    $makeGuess = $_POST["makeGuess"] ?? null;
    $startOver = $_POST["startOver"] ?? null;
    $cheat = $_POST["cheat"] ?? null;

    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $guess = $_SESSION["guess"] ?? null;

    if ($makeGuess) {
        try {
            $res = $guess->makeGuess($guessedNumber);
            if ($res == "<br><h2>CORRECT!</h2>" .
                "<br><p>If you wanna play again, press Start from Beginning!") {
                $guess->tries = 6;
                $winorlose = "yes";
            } elseif ($res == "<h2>GAME OVER!</h2><br>" .
                "<p>Press the button to try again.</p>") {
                $winorlose = "yes";
                $guess->tries = 6;
            }
        } catch (Lioo19\Guess\GuessException $e) {
            $res = $e->getMessage();
        } catch (TypeError $e) {
            $res = "Bara siffror går att gissa på!";
        }
        $_SESSION["tries"] = $guess->triesLeft();
        $_SESSION["res"] = $res;
    }

    if ($startOver) {
        return $app->response->redirect("guess/init");
    } elseif ($tries == 0) {
        return $app->response->redirect("guess/init");
    } elseif ($winorlose) {
        return $app->response->redirect("guess/winorlose");
    }

    // var_dump($guessedNumber);
    // var_dump($makeGuess);
    // var_dump($startOver);
    // var_dump($cheat);
    // var_dump($number);
    // var_dump($tries);
    // var_dump($guess);

    // $_SESSION["tries"] = $tries;
    $_SESSION["number"] = $number;
    $_SESSION["guess"] = $guess;
    $_SESSION["makeGuess"] = $makeGuess;
    $_SESSION["startOver"] = $startOver;
    $_SESSION["cheat"] = $cheat;
    $_SESSION["guessedNumber"] = $guessedNumber;

    return $app->response->redirect("guess/play");
});


/**
 * WIN OR LOSE GET
 */
$app->router->get("guess/winorlose", function () use ($app) {
    $title = "Win or lose!";
    $guess = $_SESSION["guess"];
    $number = $guess->getNumber();
    $guessedNumber = $_SESSION["guessedNumber"] ?? null;
    $res = $_SESSION["res"] ?? null;

    $data = [
        "guess" => $guess,
        "startOver" => $startOver ?? null,
        "res" => $res
    ];

    $app->page->add("guess/winorlose", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * WIN OR LOSE POST
 */
$app->router->post("guess/winorlose", function () use ($app) {
    $title = "Guess";

    $startOver = $_POST["startOver"] ?? null;

    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $guess = $_SESSION["guess"] ?? null;

    if ($startOver) {
        return $app->response->redirect("guess/init");
    } elseif ($tries == 0) {
        return $app->response->redirect("guess/init");
    }

    $_SESSION["number"] = $number;
    $_SESSION["guess"] = $guess;
    $_SESSION["startOver"] = $startOver;

    return $app->response->redirect("guess/play");
});
