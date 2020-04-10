<?php
/**
* Game of guess my number with post
*
*/
require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";


session_name("gameSession");
session_start();
// var_dump($_SESSION);

if (!isset($_SESSION["guess"])) {
    $_SESSION["guess"] = new Guess();
}

$guess = $_SESSION["guess"];
$number = $guess->getNumber();
$tries = $guess->triesLeft();

$guessedNumber = $_POST["guessedNumber"] ?? null;
$makeGuess = $_POST["makeGuess"] ?? null;
$startOver = $_POST["startOver"] ?? null;
$cheat = $_POST["cheat"] ?? null;


// Include template to render page
require __DIR__ . "/view/guess_post.php";
require __DIR__ . "/view/debug_session_post_get.php";

// var_dump($_SESSION);
