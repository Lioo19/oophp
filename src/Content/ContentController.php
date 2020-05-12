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
    private $contentClass;

    /**
     * Setup to database and create new contentClass
     *
     * @return object
     */
    public function initialize()
    {
        $this->app->db->connect();
        $this->contentClass = new Content($this->app->db);
    }

    /**
     * This is the index method action
     *
     *
     * @return object
     */
    public function indexAction()
    {
        $title = "Blogg";
        $page = $this->app->page;

        $res = $this->contentClass->getAllFromContent();

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
     *
     * @return object
     */
    public function blogAction() : object
    {
        $title = "blog";
        $page = $this->app->page;

        $res = $this->contentClass->getAllFromContent();

        foreach ($res as $key => $value) {
            $supportObject = $this->contentClass->createSupport();
            $value->data = $supportObject->textFilter($value->data, $value->filter);
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
        $title = $request->getGet("slug", null);

        if ($title) {
            $content = $this->contentClass->getSlugContent($title);
        } else {
            $content = $this->contentClass->getIdContent(1);
        }

        $supportObject = $this->contentClass->createSupport();
        $content->data = $supportObject->textFilter($content->data, $content->filter);

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
        $page = $this->app->page;
        $request = $this->app->request;

        $res = $this->contentClass->getAllFromContent();

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
        $page = $this->app->page;
        $request = $this->app->request;
        $id = $request->getGet("id", null);

        $content = $this->contentClass->getIdContent($id);

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
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $response = $this->app->response;
        $request = $this->app->request;

        $contentId = $request->getPost("contentId") ?: $request->getGet("id");

        $contentTitle = $request->getPost("contentTitle", null);
        $contentPath = $request->getPost("contentPath", null);
        $contentSlug = $request->getPost("contentSlug", null);
        $contentData = $request->getPost("contentData", null);
        $contentType = $request->getPost("contentType", null);
        $contentFilter = $request->getPost("contentFilter", null);
        $contentPublish = $request->getPost("contentPublish", null);
        $contentId = $request->getPost("contentId", null);

        $supportObject = $this->contentClass->createSupport();

        if (!$contentSlug) {
            $contentSlug = $supportObject->slugify($contentTitle);
        }

        if ($contentSlug) {
            $res = $this->contentClass->getSlugContent($contentSlug);
            if (!$res) {
                $contentSlug = $contentSlug . $contentId;
            }
        }

        if ($contentPath) {
            $resPath = $this->contentClass->getPathContent($contentPath);
            if ($resPath) {
                $contentPath = $contentPath . $contentId;
            }
        } else {
            $contentPath = null;
        }

        $this->contentClass->editContent(
            $contentTitle,
            $contentPath,
            $contentSlug,
            $contentData,
            $contentType,
            $contentFilter,
            $contentPublish,
            $contentId
        );

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
        $page = $this->app->page;

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
        $response = $this->app->response;
        $request = $this->app->request;

        $contentTitle = $request->getPost("contentTitle") ?: $request->getGet("title");

        $this->contentClass->createContent($contentTitle);

        $contentId = $this->contentClass->getIdContentByTitle($contentTitle);
        $contentId = json_encode($contentId[0]);
        $contentId = substr($contentId, 6, -1);

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
        $page = $this->app->page;
        $request = $this->app->request;
        $id = $request->getGet("id", null);

        $content = $this->contentClass->getIdContent($id);

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
        $response = $this->app->response;
        $request = $this->app->request;
        $id = $request->getPost("id") ?: $request->getGet("id");

        $this->contentClass->deleteContent($id);

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
        $page = $this->app->page;
        $request = $this->app->request;

        $res = $this->contentClass->getPages();

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
        $title = $request->getGet("slug", null);

        if ($title) {
            $content = $this->contentClass->getSlugContent($title);
        } else {
            $content = $this->contentClass->getIdContent(1);
        }

        $supportObject = $this->contentClass->createSupport();
        $content->data = $supportObject->textFilter($content->data, $content->filter);

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
