<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>100</title>
</head>

<h1> Kasta Tärning </h1>
<h4>Vinn över datorn, först till 100!</h4>


<div style="float: right;">
    <?= $scoreBoard ?>
</div>
<div>
    <p> Spelare: <?= $playing->getPlayerName(); ?>
    <p>Nuvarande poäng (osparade):
        <?= $turnScore ?>
    </p>

</div>

<?php if ($getValuesLastRoll) : ?>
    <p>Tärningsslaget visar
        <?php
        foreach ($getValuesLastRoll as $values) {
            $res = "<br>" . $values;
            echo $res;
        }
            $res = rtrim($res, ", ");
        ?></p>
<?php endif; ?>

<?php if ($anyOnes) : ?>
    <form method="post" action="playdice">
    <input type="submit" class="button" name="newturn" value="Nästa omgång">
    <input type="submit" class="button" name="restart" value="Starta om spelet">
    </form>
<?php elseif ($computerPlaying && $computerChoseSave) : ?>
    <p class="action">Datorn väljer att spara sin omgång</p>
    <form method="post" action="playdice">
        <input type="submit" name="save" class="button" value="Nästa omgång">
        <input type="submit" class="button" name="restart" value="Starta om spelet">
    </form>
<?php elseif ($computerPlaying) : ?>
    <p class="action">Datorn väljer att slå tärningarna</p>
    <form method="post" action="playdice">
        <input type="submit" name="throwcomputer" class="button" value="Hjälp datorn att slå">
        <input type="submit" class="button" name="restart" value="Starta om spelet">
    </form>
<?php else : ?>
    <form method="post" action="playdice">
        <input type="submit" class="button" name="throw" value="Slå dina tärningar"/>
        <input type="submit" class="button" name="save" value="Spara"/>
        <input type="submit" class="button" name="restart" value="Starta om spelet"/>
    </form>
<?php endif; ?>


<!-- <pre>
<?= var_dump($_POST); ?> -->
