<?php

namespace Anax\View;

/**
 * Page for when game is over!
 */


?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>100</title>
</head>

<h1> Kasta Tärning </h1>
<div>
    <h3>Spelet är slut!</h3>

    <div style="float: right;">
        <?= $scoreBoard ?>
    </div>

    <p> Vinnaren blev <strong><?= $winningPlayer ?></strong>!!</p>
    <p>Vill du spela igen? </p>
    <form method="POST">
        <input type="submit" class="button" name="restart" value="Starta om spelet"/>
    </form>
</div>
<!-- <pre>
<?= var_dump($_SESSION); ?> -->
