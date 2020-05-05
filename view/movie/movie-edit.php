<?php

namespace Anax\View;

?>

<form method="post">
    <fieldset>
    <legend>Ändra</legend>
    <input type="hidden" name="id" value="<?= $movie->id ?>"/>

    <p>
        <label>Id<br>
        <select name="id">
            <?php foreach ($movies as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->id ?>: <?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <label>Title:<br>
        <input type="text" name="title" value="<?= $movie->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="year" value="<?= $movie->year ?>"/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="image" value="<?= $movie->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="save" value="Save">
        <input type="reset" value="Reset">
    </p>
    <p>
        <a href="<?= url("movie/select") ?>">Välj Film</a> |
        <a href="<?= url("movie/") ?>">Visa alla</a>
    </p>
    </fieldset>
</form>
