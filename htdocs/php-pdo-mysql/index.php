<?php
// Get essentials
require "src/autoload.php";
require "src/config.php";
require "src/function.php";

// Get incoming
$route = getGet("route", "");

// General variabels (available to the views)
$titleExtended = " | My Movie Database";
$view = [];
$db = new Database();
$db->connect($databaseConfig);
$sql = null;
$resultset = null;

// Simple router
switch ($route) {
    case "":
        $title = "Show all movies";
        $view[] = "view/show-all.php";
        $sql = "SELECT * FROM movie;";
        $resultset = $db->executeFetchAll($sql);
        break;

    case "show-all-sort":
        $title = "Show and sort all movies";
        $view[] = "view/show-all-sort.php";

        // Only these values are valid
        $columns = ["id", "title", "year", "image"];
        $orders = ["asc", "desc"];

        // Get settings from GET or use defaults
        $orderBy = getGet("orderby") ?: "id";
        $order = getGet("order") ?: "asc";

        // Incoming matches valid value sets
        if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
            die("Not valid input for sorting.");
        }

        $sql = "SELECT * FROM movie ORDER BY $orderBy $order;";
        $resultset = $db->executeFetchAll($sql);
        break;

    case "show-all-paginate":
        $title = "Show, paginate movies";
        $view[] = "view/show-all-paginate.php";

        // Get number of hits per page
        $hits = getGet("hits", 4);
        if (!(is_numeric($hits) && $hits > 0 && $hits <= 8)) {
            die("Not valid for hits.");
        }

        // Get max number of pages
        $sql = "SELECT COUNT(id) AS max FROM movie;";
        $max = $db->executeFetchAll($sql);
        $max = ceil($max[0]->max / $hits);

        // Get current page
        $page = getGet("page", 1);
        if (!(is_numeric($hits) && $page > 0 && $page <= $max)) {
            die("Not valid for page.");
        }
        $offset = $hits * ($page - 1);

        // Only these values are valid
        $columns = ["id", "title", "year", "image"];
        $orders = ["asc", "desc"];

        // Get settings from GET or use defaults
        $orderBy = getGet("orderby") ?: "id";
        $order = getGet("order") ?: "asc";

        // Incoming matches valid value sets
        if (!(in_array($orderBy, $columns) && in_array($order, $orders))) {
            die("Not valid input for sorting.");
        }

        $sql = "SELECT * FROM movie ORDER BY $orderBy $order LIMIT $hits OFFSET $offset;";
        $resultset = $db->executeFetchAll($sql);
        break;

    case "reset":
        $title = "Resetting the database";
        $view[] = "view/reset.php";
        break;

    case "select":
        $title = "SELECT *";
        $view[] = "view/select.php";
        $sql = "SELECT * FROM movie;";
        $resultset = $db->executeFetchAll($sql);
        break;

    case "search-title":
        $title = "SELECT * WHERE title";
        $view[] = "view/search-title.php";
        $view[] = "view/show-all.php";
        $searchTitle = getGet("searchTitle");
        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $resultset = $db->executeFetchAll($sql, [$searchTitle]);
        }
        break;

    case "search-year":
        $title = "SELECT * WHERE year";
        $view[] = "view/search-year.php";
        $view[] = "view/show-all.php";
        $year1 = getGet("year1");
        $year2 = getGet("year2");
        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year2]);
        }
        break;

    case "movie-select":
        $movieId = getPost("movieId");

        if (getPost("doDelete")) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->execute($sql, [$movieId]);
            header("Location: ?route=movie-select");
            exit;
        } elseif (getPost("doAdd")) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $db->execute($sql, ["A title", 2017, "img/noimage.png"]);
            $movieId = $db->lastInsertId();
            header("Location: ?route=movie-edit&movieId=$movieId");
            exit;
        } elseif (getPost("doEdit") && is_numeric($movieId)) {
            header("Location: ?route=movie-edit&movieId=$movieId");
            exit;
        }

        $title = "Select a movie";
        $view[] = "view/movie-select.php";
        $sql = "SELECT id, title FROM movie;";
        $movies = $db->executeFetchAll($sql);
        break;

    case "movie-edit":
        $title = "UPDATE movie";
        $view[] = "view/movie-edit.php";

        $movieId    = getPost("movieId") ?: getGet("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear  = getPost("movieYear");
        $movieImage = getPost("movieImage");

        if (getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
            header("Location: ?route=movie-edit&movieId=$movieId");
            exit;
        }

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];
        break;

    default:
        ;
};

// Render the page
require "view/header.php";
foreach ($view as $value) {
    require $value;
}
require "view/footer.php";
