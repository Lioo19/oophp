<?php

namespace Anax\View;

?>

<h1>CRUD</h1>

<h4>Här kan du:</h4>
<p>
-Ändra de filmer som redan finns<br>
-Radera en film <br>
-Lägga till en ny film</p>

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
        <input type="submit" class="button" name="add" value="Ny Film">
        <input type="submit" class="button" name="edit" value="Redigera">
        <input type="submit" class="button" name="delete" value="Radera">
    </p>
</form>
