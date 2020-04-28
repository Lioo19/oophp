<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dice</title>
</head>

<h1> Kasta Tärning Kmom04 </h1>
<h4>Bestäm antal tärningar och sidor!</h4>

<!-- <p> Det är du mot datorn, först till 10 vinner!</p> -->
<p><i>Spelet går ut på att komma först till 100. <br>
Du börjar med att välja hur många tärningar du vill kasta varje gång och hur många sidor varje tärning ska ha (minst 4).
Resultatet av kastet adderas till din pott för rundan.<br>
Du har sedan två val, kasta igen eller spara resultatet.<br>
Om du någon gång slår en etta på någon av tärningarna är din runda genast över och ditt resultat går förlorat.<br>
Därefter är det datorns tur, som får samma typ av runda och samma typ av val.
<br>
Vem som börjar spela väljs av ett osynligt tärningskast.</i></p>
<p><strong> Hur många tärningar vill du rulla varje gång? Ju fler, desto svårare!</strong></p>
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
    <br>
    <br>
    <input type="submit" class="button" name="saveParams" value="Spara">
</form>
