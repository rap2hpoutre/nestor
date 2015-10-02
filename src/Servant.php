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
     * @var mixed[] shared properties
     */
    private $properties;

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
                call_user_func($task->up, $this);
            }
        } catch (TaskException $task_exception) {
            while ($this->key >= 0) {
                call_user_func($this->tasks[$this->key]->down, $this);
                $this->key--;
            }
        }
    }

    /**
     * @param string $message
     * @throws TaskException
     */
    public function fail($message = '')
    {
        throw new TaskException($message);
    }

    /**
     * @param $key
     * @param $value
     */
    public function put($key, $value)
    {
        $this->properties[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     */
    public function push($key, $value)
    {
        $this->properties[$key][] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->properties[$key];
    }

}
