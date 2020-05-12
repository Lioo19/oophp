<form method="post">
    <fieldset>
    <legend>Delete</legend>

    <input type="hidden" name="contentId" value="<?= esc($content->id) ?>"/>

    <p>
        <label>Inlägg:<br>
            <input type="text" name="contentTitle" value="<?= esc($content->title) ?>" readonly/>
        </label>
    </p>

    <p>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i>Radera</button>
    </p>
    </fieldset>
</form>
