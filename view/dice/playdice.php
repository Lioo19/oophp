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
    <title>100</title>
</head>

<h1> Kasta Tärning </h1>
<h4>Vinn över datorn, först till 100!</h4>

<!-- <?php
    echo "<pre>dataNUMBER";
    var_dump($data["number"]);
    echo "data";
    var_dump($data);
    echo "guessedNumber";
    var_dump($guessedNumber);
    echo"</pre>";?> -->

    <!-- <h1><?= $title ?></h1> -->
    <div>
        <p>Nuvarande poäng (osparade): 
            <?= $unsavedScore ?>
        </p>

    </div>
    <div style="float: right;">
        <?= $scoreBoard ?>
    </div>

<?php if ($lastRoll) : ?>
    <p>Tärningsslaget visar
        <?php
            foreach ($lastRoll as $lr) {
                $res = "<br>" . $lr;
                echo $res;
            }
            $res = rtrim($res, ", ");
            ?></p>
<?php endif; ?>

<!--
<?php if ($startOver) : ?>
    <p>The game has been reset</p>
<?php endif; ?>

<?php if ($cheat) : ?>
    <p>Cheat: The number is <b> <?= $number ?> </b></p>
<?php endif; ?> -->
<?php if ($gocomputergo) : ?>
    <form method="POST">
        <input type="submit" class="button" name="throwcomputer" value="Slå för datorn"/>
    </form>
<?php else : ?>
    <form method="POST">
        <input type="submit" class="button" name="throw" value="Slå dina tärningar"/>
        <input type="submit" class="button" name="save" value="Spara"/>
        <!-- <input type="submit" class="button" name="throwComputer" value="Slå för datorn"/> -->
        <input type="submit" class="button" name="restart" value="Starta om spelet"/>
    </form>
<?php endif; ?>
<!-- <pre>
<?= var_dump($_POST); ?> -->
