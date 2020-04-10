<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Me-app</title>
</head>

<h1> GUESS THE NUMBER </h1>

<!-- <?php
    echo "<pre>data";
    var_dump($data);
    echo"</pre>";?> -->

    <p><b> <?= $res ?></b></p>

<form id="mainform" method="POST">
    <input type="submit" class="button" name="startOver" value="Start from beginning">
</form>



<!-- <pre>
<?= var_dump($_POST); ?> -->
