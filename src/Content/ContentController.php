<?php

namespace Lioo19\Content;

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
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the action for connecting to the database
     *
     * @return void
     */
    public function connection()
    {
        $this->app->db->connect();
    }

    /**
     * This is the index method action
     * redirecting instantly to init
     * and booting up the page
     *
     * @return object
     */
    public function indexAction()
    {
        $title = "Blogg";
        $page = $this->app->page;
        $db = $this->app->db;

        $this->connection();
        $sql = "SELECT * FROM content;";
        $res = $db->executeFetchAll($sql);

        $data = [
            "res" => $res,
            "check" => null
        ];

        $page->add("content/header");
        $page->add("content/index", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Showing the blog-view
     * Fungerar men inte så fin
     *
     * @return object
     */
    public function blogviewAction() : object
    {
        $title = "blog-view";
        $request = $this->app->request;
        $response = $this->app->response;
        $page = $this->app->page;
        $db = $this->app->db;

        $this->connection();

        $sql = "SELECT * FROM content;";

        $res = $db->executeFetchAll($sql);

        $data = [
            "title" => $title,
            "res"   => $res
        ];

        $page->add("content/header", $data);
        $page->add("content/blogview", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Get for admin-view
     *
     * @return object
     */
    public function adminAction() : object
    {
        $title = "ADMIN";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;

        $this->connection();
        $sql = "SELECT * FROM content;";
        $res = $db->executeFetchAll($sql);

        $data = [
            "title"         => $title,
            "res"           => $res
        ];

        $page->add("content/header", $data);
        $page->add("content/admin", $data);

        return $page->render($data);
    }

    /**
     * Create a new post, get-route
     *
     * @return object
     */
    public function newAction() : object
    {
        $title = "Nytt inlägg";
        $session = $this->app->session;
        $page = $this->app->page;
        $db = $this->app->db;

        $page->add("content/header");
        $page->add("content/new");

        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * Get for admin-view
     *
     * @return object
     */
    public function pagesAction() : object
    {
        $title = "Visa sidorx";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;

        $this->connection();
        $sql = "SELECT * FROM content;";
        $res = $db->executeFetchAll($sql);

        $data = [
            "title"         => $title,
            "res"           => $res
        ];

        $page->add("content/header", $data);
        $page->add("content/pages", $data);

        return $page->render($data);
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
            return $response->redirect("content/select");
        }

        if ($delete && is_numeric($id)) {
            $this->deleteActionPost($id);
            return $response->redirect("content/select");
        } elseif ($add) {
            $this->addActionPost();
            //fetching last inserted ID
            $id = $db->lastInsertId();
            return $response->redirect("content/edit?id=$id");
        } elseif ($edit && is_numeric($id)) {
            return $response->redirect("content/edit?id=$id");
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

        $deleteSql = "DELETE FROM content WHERE id = ?;";
        //vill man få en return med alla här? kanske är nice?
        $db->execute($deleteSql, [$id]);

        return $response->redirect("content/select");
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

        return $response->redirect("content/select");
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

        return $response->redirect("content/select");
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

        $sql = "SELECT * FROM content WHERE id = ?;";
        $chosenMovie = $db->executeFetchAll($sql, [$id]);
        // var_dump($chosenMovie);
        $chosenMovie = $chosenMovie[0];

        $data = [
          "movie" => $chosenMovie ?? null,
        ];

        $page->add("content/header");
        $page->add("content/edit", $data);

        return $page->render([
          "title" => $title
        ]);
    }
}
