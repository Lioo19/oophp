<?php
/**
 * Show all movies.
 */

// $app->router->get("movie", function () use ($app) {
//     $title = "Movie database | oophp";
//
//     $app->db->connect();
//     $sql = "SELECT * FROM movie;";
//     $res = $app->db->executeFetchAll($sql);
//
//     $app->page->add("movie/navbar");
//     $app->page->add("movie/index", [
//         "res" => $res,
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });

// FUNGERAR
// $app->router->get("movie/search-title", function () use ($app) {
//     $title = "Sök på titel | oophp";
//
//     $app->db->connect();
//     $searchTitle = $app->request->getGet("searchTitle");
//
//     $res = null;
//     if($searchTitle) {
//         $sql = "SELECT * FROM movie WHERE title LIKE ?;";
//         $res = $app->db->executeFetchAll($sql, [$searchTitle]);
//     } else {
//         //set to show all movies if search not done
//         $sql = "SELECT * FROM movie;";
//         $res = $app->db->executeFetchAll($sql);
//     }
//
//     $data = [
//         "title"         => $title,
//         "searchTitle"   => $searchTitle,
//         "res"           => $res
//     ];
//
//     $app->page->add("movie/navbar", $data);
//     $app->page->add("movie/search-title", $data);
//     $app->page->add("movie/index", $data);
//
//     return $app->page->render($data);
// });
//
// $app->router->get("movie/search-year", function () use ($app) {
//     $title = "Sök på årtal| oophp";
//     // $title = "SELECT * WHERE year";
//     // $view[] = "view/search-year.php";
//     // $view[] = "view/show-all.php";
//     // $year1 = getGet("year1");
//     // $year2 = getGet("year2");
//     // if ($year1 && $year2) {
//     //     $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
//     //     $resultset = $db->executeFetchAll($sql, [$year1, $year2]);
//     // } elseif ($year1) {
//     //     $sql = "SELECT * FROM movie WHERE year >= ?;";
//     //     $resultset = $db->executeFetchAll($sql, [$year1]);
//     // } elseif ($year2) {
//     //     $sql = "SELECT * FROM movie WHERE year <= ?;";
//     //     $resultset = $db->executeFetchAll($sql, [$year2]);
//     // }
//     $app->db->connect();
//
//     $sql = "SELECT * FROM movie;";
//     $year1 = $app->request->getGet("year1");
//     $year2 = $app->request->getGet("year2");
//     $params = null;
//
//     if ($year1 && $year2) {
//         $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
//         $params = [$year1, $year2];
//     } elseif ($year1) {
//         $sql = "SELECT * FROM movie WHERE year >= ?;";
//         $params = [$year1];
//     } elseif ($year2) {
//         $sql = "SELECT * FROM movie WHERE year <= ?;";
//         $params = [$year2];
//     }
//
//     $res = null;
//     if ($params) {
//         $res = $app->db->executeFetchAll($sql, $params);
//     } else {
//         $res = $app->db->executeFetchAll($sql);
//     }
//
//     $data = [
//         "title" => $title,
//         "year1" => $year1,
//         "year2" => $year2,
//         "res"   => $res
//     ];
//
//     $app->page->add("movie/navbar", $data);
//     $app->page->add("movie/search-year", $data);
//     $app->page->add("movie/index", $data);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
//
// $app->router->get("movie-search-year", function () use ($app) {
//     $title = "Movie database | oophp";
//
//     $app->db->connect();
//     $sql = "SELECT * FROM movie;";
//     $res = $app->db->executeFetchAll($sql);
//
//     $app->page->add("movie/index", [
//         "res" => $res,
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
//
// // This is movie-select in original
// //POST
// $app->router->get("movie-crud", function () use ($app) {
//     $title = "Movie database | oophp";
//
//     $app->db->connect();
//     $sql = "SELECT * FROM movie;";
//     $res = $app->db->executeFetchAll($sql);
//
//     $app->page->add("movie/index", [
//         "res" => $res,
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
//
// //Movie-edit OR update movie
// $app->router->get("movie-edit", function () use ($app) {
//     $title = "Movie database | oophp";
//
//     $app->db->connect();
//     $sql = "SELECT * FROM movie;";
//     $res = $app->db->executeFetchAll($sql);
//
//     $app->page->add("movie/index", [
//         "res" => $res,
//     ]);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
