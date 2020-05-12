<?php

namespace Lioo19\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
* Class for content
*
*/
class Content
{

    /**
    * Constructor which takes database path as param
    *@param object database
    *
    * @return void
    */
    public function __construct($db)
    {
        $this->db = $db;
        $this->db->connect();
    }

    /**
    * Method that returns everything from content table
    *
    * @return object
    */
    public function getAllFromContent()
    {
        $sql = "SELECT * FROM content;";
        $res = $this->db->executeFetchAll($sql);

        return $res;
    }

    /**
    * Method that returns specific entry with slug
    *
    * @return object
    */
    public function getSlugContent($slug)
    {
        $sql = "SELECT * FROM content WHERE slug = ?;";
        $res = $this->db->executeFetch($sql, [$slug]);

        return $res;
    }

    /**
    * Method that returns specific entry with id
    *
    * @return object
    */
    public function getIdContent($id)
    {
        $sql = "SELECT * FROM content WHERE id = ?;";
        $res = $this->db->executeFetch($sql, [$id]);

        return $res;
    }

    /**
    * Method that returns specific entry with path
    *
    * @return object
    */
    public function getPathContent($path)
    {
        $sql = "SELECT * FROM content WHERE path = ?;";
        $res = $this->db->executeFetch($sql, [$path]);

        return $res;
    }

    /**
    * Get content id by title
    *
    * @return object
    */
    public function getIdContentByTitle($title)
    {
        $sql = "SELECT id FROM content WHERE title = ?;";
        $res = $this->db->executeFetchAll($sql, [$title]);

        return $res;
    }

    /**
    * Method for editing
    *
    * @return void
    */
    public function editContent($title, $path, $slug, $data, $type, $filter, $publish, $id)
    {
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $this->db->execute($sql, [$title, $path, $slug, $data, $type, $filter, $publish, $id]);
    }

    /**
    * Method for creating
    *
    * @return void
    */
    public function createContent($title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->db->execute($sql, [$title]);
    }

    /**
    * Method for deleting
    *
    * @return void
    */
    public function deleteContent($id)
    {
        $sql = "DELETE FROM content WHERE id = ?;";
        $this->db->execute($sql, [$id]);
    }

    /**
    * Get for pages
    *
    * @return object
    */
    public function getPages()
    {
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
        $res = $this->db->executeFetchAll($sql, ["page"]);

        return $res;
    }

    /**
    * method for creating support
    *
    * @param $data
    * @param $filters
    *
    * @return object
    */
    public function createSupport()
    {
        $support = new \Lioo19\Content\Support();

        return $support;
    }
}
