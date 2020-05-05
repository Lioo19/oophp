<?php

namespace Anax\View;

?>

<form method="get">
    <fieldset class="moviefield">
    <legend>Search</legend>
    <input type="hidden" name="route" value="search-title">
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= esc($searchTitle) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="search" value="Search">
    </p>
    <p><a class="moviebutton" href="<?= url("movie") ?>">Visa alla</a></p>
    </fieldset>
</form>
