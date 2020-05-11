<?php

namespace Anax\View;

/**
 * Template file to render a view with content.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
if (!$res) {
    return;
}
// var_dump($data);

?>
<h1> Text Tester </h1>
<p> På sidorna i menyn ovan kan du välja att testa de olika textfilter som finns i klassen MyTextFilter.
    <br>Klicka på någon av knapparna för att se resultatet!</p>
