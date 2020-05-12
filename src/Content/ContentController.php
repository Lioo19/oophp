<?php

namespace Lioo19\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A  controller for the content page
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
    * @var $support keeping the support class
    *
    */
    private $support;


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
     * Creating a support object and returning it
     *
     * @return void
     */
    public function createSupport()
    {
        $support = new \Lioo19\Content\Support();
        return $support;
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
    public function blogAction() : object
    {
        $title = "blog";
        $request = $this->app->request;
        $response = $this->app->response;
        $page = $this->app->page;
        $db = $this->app->db;

        $this->connection();

        $sql = "SELECT * FROM content;";

        $res = $db->executeFetchAll($sql);

        foreach ($res as $key => $value) {
            $filters = $value->filter;
            $data = $value->data;

            $supportObject = $this->createSupport();
            $value->data = $supportObject->textFilter($data, $filters);
        }

        $data = [
            "title" => $title,
            "res"   => $res
        ];

        $page->add("content/header", $data);
        $page->add("content/blog", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Post-route for blog-page
     *
     * @return object
     */
    public function blogActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        $db = $this->app->db;

        $slug = $request->getGet("slug", null);

        if ($slug) {
            return $response->redirect("content/blogpost?slug=$slug");
        } else {
            return $response->redirect("content/blog");
        }
    }

    /**
     * Showing the blogpost-view
     *
     * @return object
     */
    public function blogpostAction() : object
    {
        $request = $this->app->request;
        $page = $this->app->page;
        $db = $this->app->db;
        $title = $request->getGet("slug", null);

        $this->connection();

        if ($title) {
            $sql = "SELECT * FROM content WHERE slug = ?;";
            $content = $db->executeFetchAll($sql, [$title]);
        } else {
            $sql = "SELECT * FROM content WHERE id = 1;";
            $content = $db->executeFetchAll($sql);
        }

        $content = $content[0];

        $filters = $content->filter;
        $data = $content->data;

        $supportObject = $this->createSupport();
        $content->data = $supportObject->textFilter($data, $filters);

        $data = [
            "content"   => $content
        ];

        $page->add("content/header");
        $page->add("content/blogpost", $data);

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
     * Get for edit-view
     *
     * @return object
     */
    public function editAction() : object
    {
        $title = "Edit";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;
        $id = $request->getGet("id", null);

        $this->connection();
        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $db->executeFetchAll($sql, [$id]);
        $content = $content[0];

        $data = [
            "title"         => $title,
            "content"       => $content
        ];

        $page->add("content/header", $data);
        $page->add("content/edit", $data);

        return $page->render($data);
    }

    /**
     * POST for edit-option, edits in database
     * FUNKAR MEN INGEN RESPONS PÅ ATT INLÄGGET SPARAS
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $request = $this->app->request;
        $this->connection();

        $contentId = $request->getPost("contentId") ?: $request->getGet("id");

        $contentTitle = $request->getPost("contentTitle", null);
        $contentPath = $request->getPost("contentPath", null);
        $contentSlug = $request->getPost("contentSlug", null);
        $contentData = $request->getPost("contentData", null);
        $contentType = $request->getPost("contentType", null);
        $contentFilter = $request->getPost("contentFilter", null);
        $contentPublish = $request->getPost("contentPublish", null);
        $contentId = $request->getPost("contentId", null);

        $supportObject = $this->createSupport();

        if (!$contentSlug) {
            $contentSlug = $supportObject->slugify($contentTitle);
        }

        if ($contentSlug) {
            $sqlSlug = "SELECT slug, id FROM content WHERE slug = ?;";
            $res = $db->executeFetch($sqlSlug, [$contentSlug]);
            if ($res) {
                $contentSlug = $contentSlug . $contentId;
            }
        }

        if ($contentPath) {
            $sqlPath = "SELECT path, id FROM content WHERE path = ?;";
            $resPath = $db->executeFetch($sqlPath, [$contentPath]);
            if ($resPath) {
                $contentPath = $contentPath . $contentId;
            }
        }

        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $db->execute($sql, [$contentTitle, $contentPath, $contentSlug, $contentData, $contentType, $contentFilter, $contentPublish, $contentId]);

        return $response->redirect("content/admin");
    }

    /**
     * Create a new post, get-route
     *
     * @return object
     */
    public function createAction() : object
    {
        $title = "Nytt inlägg";
        $session = $this->app->session;
        $page = $this->app->page;
        $db = $this->app->db;

        $page->add("content/header");
        $page->add("content/create");

        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * Post action to create post
     *
     * @return object
     */
    public function createActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $request = $this->app->request;
        $this->connection();

        $contentTitle = $request->getPost("contentTitle") ?: $request->getGet("title");

        $addSql = "INSERT INTO content (title) VALUES (?);";
        $db->execute($addSql, [$contentTitle]);

        $idSql = "SELECT id FROM content WHERE title = ?;";
        $contentId = $db->executeFetchAll($idSql, [$contentTitle]);
        $contentId = json_encode($contentId[0]);
        $contentId = substr($contentId, 6, -1);
        var_dump($contentId);

        return $response->redirect("content/edit?id=$contentId");
    }

    /**
     * Get for delete
     *
     * @return object
     */
    public function deleteAction() : object
    {
        $title = "delete";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;
        $id = $request->getGet("id", null);

        $this->connection();
        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $db->executeFetchAll($sql, [$id]);
        $content = $content[0];

        $data = [
            "title"         => $title,
            "content"       => $content
        ];

        $page->add("content/header", $data);
        $page->add("content/delete", $data);

        return $page->render($data);
    }

    /**
     * Post action to delete movie
     *
     *
     * @return object
     */
    public function deleteActionPost() : object
    {
        $db = $this->app->db;
        $response = $this->app->response;
        $request = $this->app->request;
        $this->connection();
        $id = $request->getPost("id") ?: $request->getGet("id");

        $deleteSql = "DELETE FROM content WHERE id = ?;";
        $db->execute($deleteSql, [$id]);

        return $response->redirect("content/admin");
    }


    /**
     * Get for pages-view
     *
     * @return object
     */
    public function pagesAction() : object
    {
        $title = "Visa sidor";
        $db = $this->app->db;
        $page = $this->app->page;
        $request = $this->app->request;

        $this->connection();
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;
        $res = $db->executeFetchAll($sql, ["page"]);

        $data = [
            "title"         => $title,
            "res"           => $res
        ];

        $page->add("content/header", $data);
        $page->add("content/pages", $data);

        return $page->render($data);
    }

    /**
     * Showing the page-view
     *
     * @return object
     */
    public function pageAction() : object
    {
        $request = $this->app->request;
        $page = $this->app->page;
        $db = $this->app->db;
        $title = $request->getGet("slug", null);

        $this->connection();

        if ($title) {
            $sql = "SELECT * FROM content WHERE slug = ?;";
            $content = $db->executeFetchAll($sql, [$title]);
        } else {
            $sql = "SELECT * FROM content WHERE id = 1;";
            $content = $db->executeFetchAll($sql);
        }

        $content = $content[0];

        $filters = $content->filter;
        $data = $content->data;

        $supportObject = $this->createSupport();
        $content->data = $supportObject->textFilter($data, $filters);

        $data = [
            "content"   => $content
        ];

        $page->add("content/header");
        $page->add("content/blogpost", $data);

        return $page->render([
            "title" => $title,
        ]);
    }
}
