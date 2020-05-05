<?php

namespace Anax\View;

?>

<form method="get">
    <fieldset class="moviefield">
    <legend>Search</legend>
    <input type="hidden" name="route" value="search-year">
    <p>
        <label>Årtal:
        <input type="number" name="year1" value="<?= $year1 ?: 1900 ?>" min="1900" max="2100"/>
        -
        <input type="number" name="year2" value="<?= $year2  ?: 2100 ?>" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="search" value="Search">
    </p>
    <p><a class="moviebutton" href="<?= url("movie") ?>">Visa alla</a></p>
    </fieldset>
</form>
