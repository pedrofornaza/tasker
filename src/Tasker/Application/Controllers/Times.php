<?php

namespace Tasker\Application\Controllers;

use DateTime;
use Exception;
use PDO;
use Tasker\Domain\Entities\Time as TimeEntity;
use Tasker\Domain\Mappers\Time as TimeMapper;
use Tasker\Application\View;

class Times
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get($id = null)
    {
        return 'You cannot access times directly.';
    }

    public function post($id = null)
    {
        $mapper = new TimeMapper($this->db);

        try {
            $datetime = new DateTime();

            $entity = new TimeEntity();
            $entity->setStart($datetime->format('Y-m-d h:i:s'));
            if ($_POST['time']['type'] == 'end') {
                $entity = $mapper->get($id);
                $entity->setEnd($datetime->format('Y-m-d h:i:s'));
            }

            $entity->setTask($_POST['time']['task']);

            $mapper->save($entity);

            header('Location: /tasks/'.$entity->getTask());

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}