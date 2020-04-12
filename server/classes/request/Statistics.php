<?php

namespace request;

use database\Connection;
use util\interfaces\Jsonable;

class Statistics extends Jsonable
{

    /** @var Connection */
    private $db;

    /** @var int */
    private $totalRequests = 0;

    /** @var array */
    private $requestsByPath = [];

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function loadTotalRequests()
    {
        $stmt = $this->db->getPdo()->prepare('SELECT COUNT(id) AS count FROM requests');
        $stmt->execute();

        $this->totalRequests = (int)$stmt->fetchColumn();
    }

    public function getTotalRequests(): int
    {
        return $this->totalRequests;
    }

    public function loadRequestsByPath()
    {
        $stmt = $this->db->getPdo()->prepare('
          SELECT path, COUNT(id) AS count FROM requests GROUP BY path ORDER BY count DESC
        ');
        $stmt->execute();

        $this->requestsByPath = [];
        foreach ($stmt->fetchAll() as $item) {
            $this->requestsByPath[$item['path']] = (int)$item['count'];
        }
    }

    public function getRequestsByPath(): array
    {
        return $this->requestsByPath;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}
