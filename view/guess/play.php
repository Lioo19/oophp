<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Me-app</title>
</head>

<h1> GUESS THE NUMBER </h1>
<h4>Guess a number between 1 and 100.</h4>

<!-- <?php
    echo "<pre>dataNUMBER";
    var_dump($data["number"]);
    echo "data";
    var_dump($data);
    echo "guessedNumber";
    var_dump($guessedNumber);
    echo"</pre>";?> -->

<form id="mainform" method="POST">
    <input type="text" class="inputf" name="guessedNumber">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <br>
    <input type="submit" class="button" name="makeGuess" value="Guess">
    <input type="submit" class="button" name="startOver" value="Start from beginning">
    <input type="submit" class="button" name="cheat" value="Cheat">
</form>

<?php if ($makeGuess) : ?>
    <p>Your guess is <?= $guessedNumber ?>: <b> <?= $res ?></b></p>
    <p>You have <?= $tries ?> tries left </p>
<?php endif; ?>

<?php if ($startOver) : ?>
    <p>The game has been reset</p>
<?php endif; ?>

<?php if ($cheat) : ?>
    <p>Cheat: The number is <b> <?= $number ?> </b></p>
<?php endif; ?>

<!-- <pre>
<?= var_dump($_POST); ?> -->
