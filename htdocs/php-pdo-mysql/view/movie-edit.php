<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>

    <p>
        <label>Title:<br> 
        <input type="text" name="movieTitle" value="<?= $movie->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br> 
        <input type="number" name="movieYear" value="<?= $movie->year ?>"/>
    </p>

    <p>
        <label>Image:<br> 
        <input type="text" name="movieImage" value="<?= $movie->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="reset" value="Reset">
    </p>
    <p>
        <a href="?route=movie-select">Select movie</a> |
        <a href="?">Show all</a>
    </p>
    </fieldset>
</form>
