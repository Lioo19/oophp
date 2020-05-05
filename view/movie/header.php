<?php

namespace Anax\View;

?>
<navbar class="header">
    <a href="<?= url("movie") ?>">Visa alla filmer</a>
    <a href="<?= url("movie/search-title") ?>">Sök på titel</a>
    <a href="<?= url("movie/search-year") ?>">Sök på årtal</a>
    <!-- <a href="<?= url("movie/edit") ?>">Editera</a> | -->
    <a href="<?= url("movie/select") ?>">CRUD</a>
</navbar>
