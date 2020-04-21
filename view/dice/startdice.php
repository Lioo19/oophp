<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Me-app</title>
</head>

<h1> Kasta Tärning </h1>
<h4>Bestäm antal tärningar och sidor!</h4>

<!-- <?php
    echo "<pre>dataNUMBER";
    var_dump($data["number"]);
    echo "data";
    var_dump($data);
    echo "guessedNumber";
    var_dump($guessedNumber);
    echo"</pre>";?> -->

<!-- <p> Det är du mot datorn, först till 10 vinner!</p> -->
<p> Hur många tärningar vill du rulla varje gång? Ju fler, desto svårare!</p>
<form id="maindice" method="POST">
    <label for="noDice">Antal Tärningar:</label>
    <br>
    <input type="number" max=6 min=1 class="inputf" placeholder="2" required="required" name="noDice" value="noDice">
    <br>
    <label for="noSides">Antal sidor på varje tärning:</label>
    <br>
    <input type="number" max=20 min=4 class="inputf" placeholder="6" required="required" name="noSides" value="noSides">
    <br>
    <label for="name">Ditt namn:</label>
    <br>
    <input type="text" class="inputf" name="playerName" placeholder="Namn">

    <!-- <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>"> -->
    <br>
    <br>
    <input type="submit" class="button" name="saveParams" value="Spara">
</form>

<!-- <pre>
<?= var_dump($_POST); ?> -->
