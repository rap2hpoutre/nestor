<?php
namespace Nestor;

/**
 * Class Servant
 * @package Nestor
 */
class Servant
{

    /**
     * @var \Nestor\Task[] Task list
     */
    private $tasks = [];

    /**
     * @var int Current task key
     */
    private $key = 0;

    /**
     * Create new Task
     *
     * @return Task
     */
    public function task()
    {
        $task = new Task;
        $this->tasks[] = $task;
        return $task;
    }

    /**
     * Run tasks, rollback if required
     */
    public function run()
    {
        try {
            foreach ($this->tasks as $this->key => $task) {
                call_user_func($task->up, $task);
            }
        } catch (TaskException $task_exception) {
            while ($this->key >= 0) {
                call_user_func($this->tasks[$this->key]->down, $this->tasks[$this->key]);
                $this->key--;
            }
        }
    }

}
