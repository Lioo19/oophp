<?php

namespace Lioo19\MyTextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A  controller for the movie functino
 *
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 *
 */
class MytextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    // /**
    //  * This is the action for connecting to the database
    //  *
    //  * @return void
    //  */
    // public function connection()
    // {
    //     $this->app->db->connect();
    // }

    /**
     * This is the index method action
     * redirecting instantly to init
     * and booting up the page
     *
     * @return object
     */
    public function indexAction()
    {
        $title = "Testpage for textfilters | oophp";
        $page = $this->app->page;
        $db = $this->app->db;

        // $this->connection();
        // $sql = "SELECT * FROM movie;";
        // $res = $db->executeFetchAll($sql);

        $data = [
            "res" => $res,
            "check" => null
        ];

        $page->add("movie/header");
        $page->add("movie/index", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Searching for movies by year-interval
     *
     * @return object
     */
    public function searchYearAction() : object
    {
        $title = "Sök på årtal| oophp";
        $request = $this->app->request;
        $response = $this->app->response;
        $page = $this->app->page;
        $db = $this->app->db;

        $this->connection();

        $sql = "SELECT * FROM movie;";
        $year1 = $request->getGet("year1");
        $year2 = $request->getGet("year2");
        $params = null;

        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $params = [$year1, $year2];
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $params = [$year1];
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $params = [$year2];
        }

        $res = null;
        if ($params) {
            $res = $db->executeFetchAll($sql, $params);
        } else {
            $res = $db->executeFetchAll($sql);
        }

        $data = [
            "title" => $title,
            "check" => "check",
            "year1" => $year1,
            "year2" => $year2,
            "res"   => $res
        ];

        $page->add("movie/header", $data);
        $page->add("movie/search-year", $data);
        $page->add("movie/index", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Get for startplay, renders the page and deletes session-scores
     *
     * @return object
     */
    public function searchTitleAction() : object
    {
        $title = "Sök på titel | oophp";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;

        $this->connection();
        $searchTitle = $request->getGet("searchTitle");

        $res = null;
        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $db->executeFetchAll($sql, [$searchTitle]);
        } else {
            //set to show all movies if search not done
            $sql = "SELECT * FROM movie;";
            $res = $db->executeFetchAll($sql);
        }

        $data = [
            "title"         => $title,
            "check"         => "check",
            "searchTitle"   => $searchTitle,
            "res"           => $res
        ];

        $page->add("movie/header", $data);
        $page->add("movie/search-title", $data);
        $page->add("movie/index", $data);

        return $page->render($data);
    }

    /**
     * Selection of single movie, with links for CRUD
     *
     * @return object
     */
    public function selectAction() : object
    {
        $title = "Select Movie | oophp";
        $session = $this->app->session;
        $page = $this->app->page;
        $db = $this->app->db;

        $this->connection();
        $sql = "SELECT id, title FROM movie;";
        $movies = $db->executeFetchAll($sql);

        $data = [
            "movies" => $movies ?? null
        ];

        $page->add("movie/header");
        $page->add("movie/select", $data);

        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * POST movie selection, redirecting to CRUD
     *
     * @return void
     */
    public function selectActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        $db = $this->app->db;

        $id = $request->getPost("id", null);
        $edit = $request->getPost("edit", null);
        $delete = $request->getPost("delete", null);
        $add = $request->getPost("add", null);

        if ((!$id && $edit) || (!$id && $delete)) {
            return $response->redirect("movie/select");
        }

        if ($delete && is_numeric($id)) {
            $this->deleteActionPost($id);
            return $response->redirect("movie/select");
        } elseif ($add) {
            $this->addActionPost();
            //fetching last inserted ID
            $id = $db->lastInsertId();
            return $response->redirect("movie/edit?id=$id");
        } elseif ($edit && is_numeric($id)) {
            return $response->redirect("movie/edit?id=$id");
        }
    }

    /**
     * Post action to delete movie
     * Doesnt need a landningpage, just removie?
     *DONE?
     *
     * @return object
     */
    public function deleteActionPost($id) : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $this->connection();

        $deleteSql = "DELETE FROM movie WHERE id = ?;";
        //vill man få en return med alla här? kanske är nice?
        $db->execute($deleteSql, [$id]);

        return $response->redirect("movie/select");
    }

    /**
     * Post action to add movie
     * DONE?
     *
     * @return object
     */
    public function addActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $request = $this->app->request;
        $this->connection();

        $title = $request->getPost("title", "Titel");
        $year = $request->getPost("year", 9999);
        $image = $request->getPost("image", "img/default.jpg");

        $addSql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $db->execute($addSql, [$title, $year, $image]);

        return $response->redirect("movie/select");
    }

    /**
     * Post action to edit movie
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $request = $this->app->request;
        $this->connection();

        $id = $request->getPost("id") ?: $request->getGet("id");
        // var_dump($id);
        $title = $request->getPost("title", "Titel");
        $year = $request->getPost("year", 9999);
        $image = $request->getPost("image", "img/default.jpg");

        $editSql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $db->execute($editSql, [$title, $year, $image, $id]);

        return $response->redirect("movie/select");
    }

    /**
     * Get action to edit movie
     *
     * @return object
     */
    public function editAction() : object
    {
        $title = " Edit movie | oophp";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;

        $this->connection();

        $id = $request->getGet("id");

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $chosenMovie = $db->executeFetchAll($sql, [$id]);
        // var_dump($chosenMovie);
        $chosenMovie = $chosenMovie[0];

        $data = [
          "movie" => $chosenMovie ?? null,
        ];

        $page->add("movie/header");
        $page->add("movie/edit", $data);

        return $page->render([
          "title" => $title
        ]);
    }
}
