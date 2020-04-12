<?php


namespace api\actions\admin\statistics;

use api\actions\admin\AdminAction;
use api\ApiResponse;
use request\Statistics;

class GetStatisticsAction extends AdminAction
{

    public function run(): ApiResponse
    {
        $statistics = new Statistics($this->db);
        $statistics->loadTotalRequests();
        $statistics->loadRequestsByPath();

        return $this->res->withData(['statistics' => $statistics]);
    }

}
