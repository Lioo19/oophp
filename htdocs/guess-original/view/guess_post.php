<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Me-app</title>

    <link rel="stylesheet" href="style.css" />
</head>

<h1> GUESS THE NUMBER </h1>
<h4>Guess a number between 1 and 100.</h4>


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
    <p>Your guess is <?= $guessedNumber ?>: <b>
        <?php try {
            echo $guess->makeGuess($guessedNumber);
        } catch (GuessException $e) {
            echo "<h3>Out of bounds: " . get_class($e) . "</h3><hr>";
        }
        $tries = $guess->triesLeft();?></b></p>
    <p>You have <?= $tries ?> tries left </p>
<?php endif; ?>

<?php if ($startOver) : $guess->resetGame()?>
    <p>The game has been reset</p>
<?php endif; ?>

<?php if ($cheat) : ?>
    <p>Cheat: The number is <b> <?= $number ?> </b></p>
<?php endif; ?>

<!-- <pre>
<?= var_dump($_POST); ?> -->
