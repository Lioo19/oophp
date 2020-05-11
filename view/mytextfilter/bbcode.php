<?php

namespace Anax\View;

// $text = file_get_contents(__DIR__ . "/../text/bbcode.txt");
// $html = bbcode2html($text);


?><!doctype html>
<html>
<meta charset="utf-8">
<title>Show off BBCode</title>

<h1>Showing off BBCode and nl2br</h1>

<h2>Source in bbcode.txt</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Filter BBCode and nl2br applied, source</h2>
<pre><?= wordwrap(htmlentities($html)) ?></pre>

<h2>Filter BBCode applied, HTML (including nl2br())</h2>
<?= $html ?>
