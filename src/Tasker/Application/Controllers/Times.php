<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Domain\Time\TimeService;
use Tasker\Infra\View;

class Times
{
    protected $timeService;

    public function __construct(TimeService $timeService)
    {
        $this->timeService = $timeService;
    }

    public function post($id = null)
    {
        try {
            $data = array_merge($_POST['time'], array('id' => $id));
            $this->timeService->save($data);

            header('Location: /tasks/'.$data['task']);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}