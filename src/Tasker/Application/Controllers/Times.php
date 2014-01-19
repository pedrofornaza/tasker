<?php

namespace Tasker\Application\Controllers;

use Exception;
use Tasker\Application\Container;
use Tasker\Application\View;

class Times
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($id = null)
    {
        return 'You cannot access times directly.';
    }

    public function post($id = null)
    {
        try {
            $timeService = $this->container['time.service'];

            $data = array_merge($_POST['time'], array('id' => $id));
            $timeService->save($data);

            header('Location: /tasks/'.$data['task']);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}