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
    <div style="float: left;">
        <p>Current unsaved points:
            <!-- <?= $unsaved ?> -->
        </p>
        <p>
            <!-- <?php foreach ($graphic as $value) : ?>
                <i class="dice-sprite <?= $value ?>"></i>
            <?php endforeach; ?> -->
            Hej
        </p>
        <form method="POST">
            <input type="submit" class="button" name="throw" value="Slå dina tärningar"/>
            <input type="submit" class="button" name="save" value="Spara"/>
            <!-- <input type="submit" class="button" name="throwComputer" value="Slå för datorn"/> -->
            <input type="submit" class="button" name="restart" value="Starta om spelet"/>
        </form>
    </div>
    <div style="float: right;">
        <!-- <?= $scoreBoard ?> -->
    </div>


<?php if ($throw) : ?>
    <p>Your guess is <?= $guessedNumber ?>: <b> <?= $res ?></b></p>
    <p>You have <?= $tries ?> tries left </p>
<?php endif; ?>

<!--
<?php if ($startOver) : ?>
    <p>The game has been reset</p>
<?php endif; ?>

<?php if ($cheat) : ?>
    <p>Cheat: The number is <b> <?= $number ?> </b></p>
<?php endif; ?> -->

<!-- <pre>
<?= var_dump($_POST); ?> -->
