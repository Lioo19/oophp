<?php

namespace Anax\View;

?>

<h1>CRUD</h1>

<h4>Här kan du:</h4>
<p>-Ändra de filmer som redan finns</p>
<p>-Radera en film</p>
<p>-Lägga till en ny film</p>

<form method="post">
    <p>
        <label>Film:<br>
        <select name="id">
            <option value="">Filmer</option>
            <?php foreach ($movies as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" class="button" name="add" value="Lägg till">
        <input type="submit" class="button" name="edit" value="Redigera">
        <input type="submit" class="button" name="delete" value="Radera">
    </p>
</form>
