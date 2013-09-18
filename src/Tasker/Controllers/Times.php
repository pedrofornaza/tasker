<?php

namespace Tasker\Controllers;

use Tasker\Entities\Time as TimeEntity;
use Tasker\Mappers\Time as TimeMapper;
use Tasker\View;

class Times
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function get($id = null)
    {
        $mapper = new TimeMapper($this->db);

        if ($id == null) {
            echo 'You should specify a Task to search';
            exit;
        }

        $time = $mapper->get($id);

        $viewName = '../templates/times/detail.php';
        $viewParams = array(
            'time' => $time,
        );

        $view = new View($viewName);
        return $view->render($viewParams);
    }

    public function post($id = null)
    {
        $mapper = new TimeMapper($this->db);

        try {
            $datetime = new \Datetime();

            $entity = new TimeEntity();
            $entity->setStart($datetime->format('Y-m-d h:i:s'));
            if ($_POST['time']['type'] == 'end') {
                $entity = $mapper->get($id);
                $entity->setEnd($datetime->format('Y-m-d h:i:s'));
            }

            $entity->setTask($_POST['time']['task']);

            $mapper->save($entity);

            header('Location: /tasks/'.$entity->getTask());
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}