<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title . $titleExtended ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<navbar class="navbar">
    <a href="?route=select">SELECT *</a> |
    <br>
    <a href="?">Show all movies</a> |
    <a href="?route=reset">Reset database</a> |
    <a href="?route=search-title">Search title</a> |
    <a href="?route=search-year">Search year</a> |
    <a href="?route=movie-select">Select</a> |
<!--    <a href="?route=movie-edit">Edit</a> | -->
    <a href="?route=show-all-sort">Show all sortable</a> |
    <a href="?route=show-all-paginate">Show all paginate</a> |
</navbar> 

<h1>My Movie Database</h1>

<main>
