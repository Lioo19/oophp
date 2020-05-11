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
        $title = "Test för textfilters ";
        $page = $this->app->page;
        $db = $this->app->db;

        // $this->connection();
        // $sql = "SELECT * FROM movie;";
        // $res = $db->executeFetchAll($sql);

        $data = [
            "res" => "hej",
            "check" => null
        ];

        $page->add("mytextfilter/header");
        $page->add("mytextfilter/index", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * BBCode test
     *
     * @return object
     */
    public function bbcodeAction() : object
    {
        $title = "BBCode test";
        $page = $this->app->page;

        $bbcode = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "../../../htdocs/textsforfilter/bbcode.txt");

        $html = $bbcode->parse($text, ["bbcode", "nl2br"]);

        $data = [
            "title" => $title,
            "text"  => $text,
            "html"  => $html,
        ];

        $page->add("mytextfilter/header", $data);
        $page->add("mytextfilter/bbcode", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Clickable links, using filter makeClickable (clickable) in MyTextFilter
     *
     * @return object
     */
    public function clickableAction() : object
    {
        $title = "Clickable link test";
        $page = $this->app->page;

        $clickable = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "../../../htdocs/textsforfilter/clickable.txt");

        $html = $clickable->parse($text, ["link"]);

        $data = [
            "title" => $title,
            "text"  => $text,
            "html"  => $html,
        ];

        $page->add("mytextfilter/header", $data);
        $page->add("mytextfilter/clickable", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Markdown
     *
     * @return object
     */
    public function markdownAction() : object
    {
        $title = "Markdown test | oophp";
        $page = $this->app->page;

        $markdown = new MyTextFilter();

        $text = file_get_contents(__DIR__ . "../../../htdocs/textsforfilter/markdown.md");

        $html = $markdown->parse($text, ["markdown"]);

        $data = [
            "title" => $title,
            "text"  => $text,
            "html"  => $html,
        ];

        $page->add("mytextfilter/header", $data);
        $page->add("mytextfilter/markdown", $data);

        return $page->render([
            "title" => $title,
        ]);
    }
    // 
    // /**
    //  * Strip
    //  *
    //  * @return object
    //  */
    // public function markdownAction() : object
    // {
    //     $title = "Strip test | oophp";
    //     $page = $this->app->page;
    //
    //     $markdown = new MyTextFilter();
    //
    //     $text = file_get_contents(__DIR__ . "../../../htdocs/textsforfilter/markdown.md");
    //
    //     $html = $markdown->parse($text, ["strip_tags"]);
    //
    //     $data = [
    //         "title" => $title,
    //         "text"  => $text,
    //         "html"  => $html,
    //     ];
    //
    //     $page->add("mytextfilter/header", $data);
    //     $page->add("mytextfilter/markdown", $data);
    //
    //     return $page->render([
    //         "title" => $title,
    //     ]);
    // }
}
