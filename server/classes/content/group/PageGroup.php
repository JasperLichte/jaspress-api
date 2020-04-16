<?php

namespace content\group;

use database\Connection;
use util\interfaces\Jsonable;

class PageGroup extends Jsonable
{

    /** @var string */
    private $slug = '';

    /** @var string[] */
    private $pages = [];

    public static function load(Connection $db, string $slug): PageGroup
    {
        $stmt = $db()->prepare('SELECT slug FROM pages WHERE group_id = ? AND deleted = "0"');
        $stmt->execute([$slug]);

        $slugs = $stmt->fetchAll($db()::FETCH_COLUMN);

        if (empty($slugs) || !count($slugs)) {
            $slugs = [];
        }

        $group = new PageGroup();
        $group->setSlug($slug);
        $group->setPages($slugs);
        return $group;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setPages(array $pages): void
    {
        $this->pages = $pages;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}
